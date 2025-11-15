<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\Org\Entities\OrgPosition;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOrgPosition implements FromView,WithStyles
{
    public function view(): View
    {
        $positions = OrgPosition::orderBy('order', 'asc')->get();
        return view('org::exports.all_positions', [
            'positions' => $positions
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
