<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportSampleQuestionBank implements FromView
{
    public function view(): View
    {
        return view('quiz::exports.sample-bulk-question');
    }
}
