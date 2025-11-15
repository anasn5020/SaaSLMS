<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SampleOrgSpecialEnrollment implements WithMultipleSheets, FromView, WithTitle, WithStyles

{


    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new SampleOrgSpecialEnrollment();
        $sheets[] = new SampleOrgSpecialEnrollmentGuidline();

        return $sheets;
    }

    public function view(): View
    {
        $users = [];
        return view('orgsubscription::exports.sample-special-enroll', compact('users'));
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
