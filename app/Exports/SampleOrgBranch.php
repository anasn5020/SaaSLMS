<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleOrgBranch implements WithMultipleSheets, FromView, WithTitle,WithStyles

{
//    use Exportable;


    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new SampleOrgBranch();
        $sheets[] = new OrgBranchGuideline();

        return $sheets;
    }

    public function view(): View
    {
        return view('org::exports.sample');
    }

    public function title(): string
    {
        return 'Import';
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
