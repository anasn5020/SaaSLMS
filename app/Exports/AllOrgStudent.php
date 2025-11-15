<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOrgStudent implements FromView, WithStyles
{
    public function view(): View
    {
        $query = User::query();
        if (Auth::user()->role_id != 1) {
            $assign_code = [];
            if (Auth::user()->policy) {
                $branches = Auth::user()->policy->branches;
                foreach ($branches as $branch) {
                    $assign_code[] = $branch->branch->code;
                }
            }
            $query->whereIn('org_chart_code', $assign_code);
        }
        $students = $query->where('role_id', 3)->where('teach_via', 1)->get();
        return view('org::exports.all_students', [
            'students' => $students
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
