<?php

namespace App\Imports;


use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Validators\Failure;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionBankMuOption;

class QuestionBankImport implements WithHeadingRow, SkipsOnFailure, WithStartRow, OnEachRow
{
    use SkipsFailures;

    public $group, $category, $subcategory;


    public function __construct($group, $category = null, $subcategory = null)
    {
        $this->group = $group;
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function prepareForValidation($data, $index)
    {
        return $data;
    }

//    public function rules(): array
//    {
//        return [
//            'question' => 'required',
//            'mark' => 'required',
//            'type' => 'required',
//        ];
//    }
//
//    public function customValidationMessages()
//    {
//        return [
//            'question.required' => trans('validation.question.required'),
//            'mark.required' => trans('validation.mark.required'),
//            'type.required' => trans('validation.type.required'),
//        ];
//    }

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }


    public function onRow(Row $row)
    {
        $row = $row->toArray();

        if (!empty($row['type']) && !empty($row['question']) && !empty($row['mark'])) {
            $options = [];
            $regex = 'option_';
            foreach ($row as $key => $value) {
                if (str_starts_with($key, $regex)) {
                    $options[str_replace($regex, '', $key)] = $value;
                }
            }

            $correct = trim($row['correct_ans'] ?? '');
            $correct_options = explode('|', $correct);


            $total = 0;


            $question = new QuestionBank([
                'question' => $row['question'],
                'marks' => $row['mark'],
                'type' => $row['type'],
                'q_group_id' => $this->group,
                'user_id' => Auth::id(),
                'number_of_option' => $total,
                'explanation' => $row['explanation']??""
            ]);
            $question->save();
            if ($row['type'] == "M") {
                $i = 1;
                foreach ($options as $key => $option) {
                    if (!empty($option)) {
                        $online_question_option = new QuestionBankMuOption();
                        $online_question_option->question_bank_id = $question->id;
                        $online_question_option->title = $option;
                        if (in_array($key, $correct_options)) {
                            $online_question_option->status = 1;
                        } else {
                            $online_question_option->status = 0;
                        }
                        $online_question_option->save();

                        $question->number_of_option = $i;
                        $question->save();
                        $i++;
                    }

                }
            }
        }


    }


    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            foreach ($failure->errors() as $error) {
                Toastr::error(trans('org.Row no') . $failure->row() . ', ' . $error, trans('common.Failed'));
            }
        }

    }
}
