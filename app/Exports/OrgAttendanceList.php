<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrgAttendanceList implements FromView
{
    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function view(): View
    {
        $enrolls = $this->query->get();
        return view('orgsubscription::exports.attendance-list', compact('enrolls'));
    }
}
