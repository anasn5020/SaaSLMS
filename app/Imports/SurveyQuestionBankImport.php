<?php

namespace App\Imports;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Survey\Entities\SurveyQuestionBank;
use Modules\Survey\Entities\SurveyQuestionBankMuOption;

class SurveyQuestionBankImport implements ToModel, WithHeadingRow
{
    public $group, $category, $subcategory;

    public function __construct($group, $category, $subcategory = null)
    {
        $this->group = $group;
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function model(array $row)
    {
        $type = $row['type']??'';
        $type = ucwords($type);

        $options = [
            'checkbox',
            'dropdown',
            'radio'
        ];
        if ($type == 'C') {
            $type = 'checkbox';
        } elseif ($type == 'D') {
            $type = 'dropdown';
        } elseif ($type == 'R') {
            $type = 'radio';
        } elseif ($type == 'L') {
            $type = 'linear_scale';
        } elseif ($type == 'T') {
            $type = 'textarea';
        }

        $total = 0;

        if (!empty($type)) {
            $question = new SurveyQuestionBank([
                'question' => $row['question'],
                'type' => $type,
                'group_id' => $this->group,
                'category_id' => $this->category,
                'sub_category_id' => $this->subcategory,
                'user_id' => Auth::user()->id,
                'number_of_option' => $total,
            ]);
            $question->save();
            if (in_array($type, $options)) {
                for ($i = 1; $i <= 6; $i++) {
                    if (isset($row['option_' . $i]) && !empty(trim($row['option_' . $i]))) {
                        $option = $row['option_' . $i];
                        $online_question_option = new SurveyQuestionBankMuOption();
                        $online_question_option->survey_question_bank_id = $question->id;
                        $online_question_option->title = $option;
                        $online_question_option->save();
                        $question->number_of_option = $i;
                        $question->save();
                    }
                }
            } elseif ($type == 'linear_scale') {
                $opt = $row['option_1'] ?? '';
                $number = explode('-', $opt);
                $number = $number[1] ?? 1;
                if ($number >= 1 && $number <= 10) {
                    $question->number_of_option = $number[1] ?? 1;
                    $question->save();
                } else {
                    Toastr::error('"' . $number . '"' . ' ' . trans('survey.is not valid number for Linear Scale'), trans('common.Error'));

                }

            }
        }

    }

    public function headingRow(): int
    {
        return 1;
    }
}
