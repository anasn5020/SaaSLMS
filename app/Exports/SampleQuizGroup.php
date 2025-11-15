<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleQuizGroup implements WithMultipleSheets, FromView, WithTitle, WithStyles, ShouldAutoSize

{
//    use Exportable;


    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new SampleQuizGroup();
        $sheets[] = new QuizGuideline();

        return $sheets;
    }

    public function view(): View
    {
        return view('advancequiz::exports.sample_group');
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
