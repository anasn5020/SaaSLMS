<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RegularStudentExport implements FromView
{
    public function view(): View
    {
        return view('studentsetting::exports.sample-regular-student');
    }
}
