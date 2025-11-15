<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Modules\Quiz\Entities\QuestionGroup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AllQuizGroup implements FromView, WithStyles
{
    public function view(): View
    {
        $groups = QuestionGroup::where('parent_id', 0)->orderBy('order', 'asc')->get();
        return view('advancequiz::exports.all_groups', [
            'groups' => $groups
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
