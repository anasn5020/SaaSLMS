<?php

namespace App\Exports;

use App\Exports\DropDownSheets\QuestionGroupSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use Modules\Quiz\Entities\QuestionGroup;
use Modules\Quiz\Entities\QuestionLevel;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AdvanceExportSampleQuestionBank implements WithTitle, WithMultipleSheets, FromView, WithEvents
{

    protected $selects;
    protected $row_count;
    protected $column_count;

    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new AdvanceExportSampleQuestionBank();
        $sheets[] = new QuestionGroupSheet();
        $sheets[] = new AdvanceExportSampleQuestionBankGideline();
        return $sheets;
    }

    public function title(): string
    {
        return 'Import';
    }

    public function __construct()
    {
        $type = ['MultiChoice', 'ShortAnswer', 'LongAnswer', 'Matching'];
        $levels = QuestionLevel::where('status', 1)->pluck('title')->toArray();
        $yesNo = ['Yes', 'No'];
        $selects = [
            ['columns_name' => 'B', 'options' => $type],
            ['columns_name' => 'C', 'options' => [], 'sheet_name' => 'question_group', 'count' => QuestionGroup::count()],
            ['columns_name' => 'D', 'options' => $levels],
            ['columns_name' => 'E', 'options' => $yesNo],
        ];
        $this->selects = $selects;
        $this->row_count = 1000;//number of rows that will have the dropdown
        $this->column_count = 11;//number of columns to be auto sized
    }

    public function view(): View
    {
        return view('advancequiz::exports.advance-sample-bulk-question');
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $row_count = $this->row_count;
                $column_count = $this->column_count;
                foreach ($this->selects as $select) {
                    $drop_column = $select['columns_name'];
                    $cell = $drop_column . '2';
                    $validation = $event->getSheet()->getDataValidation($cell);

                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setAllowBlank(false);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setErrorTitle('Input error');
                    $validation->setError('Value is not in list.');
                    $validation->setPromptTitle('Pick from list');
                    $validation->setPrompt('Please pick a value from the drop-down list.');

                    if (isset($select['sheet_name'])) {
                        $validation->setFormula1("{$select['sheet_name']}!\$A\$1:\$A\${$select['count']}");
                    } else {
                        $options = $select['options'];
                        $validation->setFormula1(sprintf('"%s"', implode(',', $options)));
                    }
                    $validation->setFormula2('');
                    // Clone validation to remaining rows
                    for ($i = 3; $i <= $row_count; $i++) {
                        $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                    }

                    // Set columns to autosize
                    for ($i = 1; $i <= $column_count; $i++) {
                        $column = Coordinate::stringFromColumnIndex($i);
                        $event->sheet->getColumnDimension($column)->setAutoSize(true);
                    }
                }
            },
        ];
    }

}
