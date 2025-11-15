<?php

namespace App\Exports;

use App\Country;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CountryList implements FromView,WithStyles
{
    public function view(): View
    {
        $countries = Country::where('active_status', 1)->get(['id', 'name']);
        return view('studentsetting::exports.country', [
            'countries' => $countries
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
