<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrgEnrollmentList implements WithMultipleSheets, FromView, WithTitle, WithStyles, WithColumnWidths

{


    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new OrgEnrollmentList();
        $sheets[] = new OrgEnrollmentListGideline();

        return $sheets;
    }

    public function view(): View
    {
        $type = request('type');
        $ids = request('class');
        if ($type == 'offline') {
            $query = Course::query();
            $query->whereHas('orgCourseList', function ($q) use ($ids) {
                $q->whereIn('plan_id', $ids);
            });
            $courses = $query->with('enrolls', 'enrolls.user')->get();
        } else {
            $query = Course::whereIn('id', $ids);
            $courses = $query->with('enrolls', 'enrolls.user')->get();
        }
        return view('orgsubscription::exports.enrollment-list', compact('courses', 'type'));
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

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 5,
            'C' => 15,
            'D' => 15,
            'E' => 10,
            'F' => 25,
            'G' => 12,
            'H' => 12,
            'I' => 12,
            'J' => 12,
            'K' => 12,
        ];
    }
}
