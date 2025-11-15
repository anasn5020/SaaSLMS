<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportSurveySampleQuestion implements WithMultipleSheets, FromView, WithTitle, WithStyles, WithColumnWidths
{

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new ExportSurveySampleQuestion();
        $sheets[] = new ExportSurveySampleQuestionGideline();

        return $sheets;
    }

    public function view(): View
    {
        return view('survey::exports.sample-bulk-question');
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

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 25,
            'C' => 12,
            'D' => 12,
            'E' => 12,
            'F' => 12,
            'G' => 12,
            'H' => 12,
            'I' => 12,
            'J' => 12,
        ];
    }
}
