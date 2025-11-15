<?php

namespace App\Exports\DropDownSheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\Quiz\Entities\QuestionGroup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuestionGroupSheet implements FromQuery, WithTitle, WithMapping, WithEvents
{


    public function query()
    {
        return QuestionGroup
            ::orderBy('order', 'asc');
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'question_group';
    }


    public function map($question_group): array
    {
        return [
            $question_group->title
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);
            },
        ];
    }
}
