<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrgAttendanceStatistic implements FromView
{
    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function view(): View
    {
        $courses = $this->query->get();
        return view('orgsubscription::exports.attendance-statistic', compact('courses'));
    }
}
