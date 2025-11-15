<?php

namespace App\Exports;

use Modules\Chat\Http\Controllers\InvitationController;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Http\Controllers\CourseInvitationController;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;

class QuizStatisticsReport implements FromView, WithStyles
{
    public function view(): View
    {
        $statisticController =new CourseInvitationController();
        $quizzes = $statisticController->courseStatisticFilterQuery()->get();
        return view('coursesetting::exports.quiz-statistic-report', [
            'quizzes' => $quizzes
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
