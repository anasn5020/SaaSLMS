<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\OrgSubscription\Entities\OrgSubscriptionCheckout;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrgSubscriptionEnrollmentCheckoutExport implements FromView, WithStyles
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $request = $this->request;
        $query = OrgSubscriptionCheckout:: with('plan', 'user');

        if (!empty($request->position)) {
            $query->whereHas('user', function ($query2) use ($request) {
                $query2->where('org_position_code', $request->position);
            });
        }
        if (!empty($request->type)) {
            $query->where('type', $request->type);
        }


        if (!empty($request->branch)) {
            $query->whereHas('user', function ($query3) use ($request) {

                $query3->where('org_chart_code', $request->branch);

            });
        }


        if (!empty($request->start_date)) {
            $query->whereDate('created_at', '>=', Carbon::parse($request->start_date));
        }
        if (!empty($request->end_date)) {
            $query->whereDate('created_at', '<=', Carbon::parse($request->end_date));
        }


        $students = $query->with('user')->latest()->get();
        return view('orgsubscription::enrollment.export', compact('students'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
