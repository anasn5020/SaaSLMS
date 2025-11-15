<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Modules\CPD\Entities\AssignStudent;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\CourseSetting\Entities\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CpdGraphExport implements FromView, WithStyles
{
    public function view(): view
    {
        $students = null;
        if (isModuleActive('CPD')) {
            $students = User::with('cpds')->where('role_id', 3)->get()
            ->map(function ($value) {
                return [
                    'id'=>$value->id,
                    'name'=>$value->name,
                    'total_course'=>$value->cpds->count(),
                ];
            });
        }
        if (auth()->user()->role_id == 3) {
            $course_ids = AssignStudent::where('student_id', auth()->user()->id)->pluck('course_id')->toArray();
            $students = Course::whereIn('id', $course_ids)->get()
            ->map(function ($value) {
                return [
                    'id'=>$value->id,
                    'name'=>$value->title,
                    'complete'=>round($value->loginUserTotalPercentage),
                ];
            });
        }
        return view('cpd::export.cpd-graph-report', [
            'students' => $students
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        foreach (range('A', 'Z') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
