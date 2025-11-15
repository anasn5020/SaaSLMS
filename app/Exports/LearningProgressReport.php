<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\OrgSubscription\Http\Controllers\OrgSubscriptionReportController;
use Modules\Quiz\Entities\QuizTest;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LearningProgressReport implements FromView, WithStyles
{
    public function view(): View
    {
        $learningController = new OrgSubscriptionReportController();
        $courses = $learningController->query()->get();
        return view('orgsubscription::exports.learning-path', [
            'courses' => $courses
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
