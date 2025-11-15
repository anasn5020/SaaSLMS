<?php

namespace App\Exports;

use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Http\Controllers\CourseInvitationController;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Contracts\View\View;

class CourseStatisticsReport implements FromView, WithStyles
{
    public function view(): View
    {
        $statisticController = new CourseInvitationController();
        $courses = $statisticController->courseStatisticFilterQuery()->get();
        return view('coursesetting::exports.course-statistic-report', [
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
