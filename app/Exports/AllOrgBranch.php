<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\Org\Entities\OrgBranch;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllOrgBranch implements FromView, WithStyles
{
    public function view(): View
    {
        $branches = OrgBranch::where('parent_id', '0')->orderBy('order', 'asc')->get();
        return view('org::exports.all_branches', [
            'branches' => $branches
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
