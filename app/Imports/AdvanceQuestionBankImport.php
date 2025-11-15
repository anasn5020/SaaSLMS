<?php

namespace App\Imports;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\AdvanceQuiz\Entities\MatchingTypeQuestionAssign;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionBankMuOption;
use Modules\Quiz\Entities\QuestionGroup;
use Modules\Quiz\Entities\QuestionLevel;

class AdvanceQuestionBankImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        try {
            $questions = [];
            $total_options = 0;
            $total_qus = 0;
            $total_ans = 0;
            $data = $connection = '';
            $opt = [];

            foreach ($rows as $key => $row) {
                if (!empty($row['no'] ?? "")) {
                    $opt = [];
                }
                if (!empty($row['no'] ?? "")) {

                    if ($row['type'] == 'MultiChoice') {
                        $type = 'M';
                    } elseif ($row['type'] == 'Matching') {
                        $type = 'X';
                    } elseif ($row['type'] == 'ShortAnswer') {
                        $type = 'S';
                    } elseif ($row['type'] == 'LongAnswer') {
                        $type = 'L';
                    } else {
                        $type = '';
                    }
                    $group = QuestionGroup::select('id')->whereLike('title', $row['question_group'] ?? '')->first();
                    $level = QuestionLevel::select('id')->whereLike('title', $row['question_level'] ?? '')->first();
                    $row['q_group_id'] = $group ? $group->id : null;
                    $row['level'] = $level ? $level->id : null;
                    $row['short_type'] = $type;
                    $row['options'] = [];
                    $questions[$key] = $row;
                }

                $opt[] = [
                    'option' => $row['option_list'] ?? '',
                    'matching' => $row['matching_answer'] ?? '',
                    'isCorrect' => $row['correct_ans'] == 1,
                ];

                $questions[array_key_last($questions)]['options'] = $opt;
            }

            foreach ($questions as $question) {
                $newQus = new QuestionBank([
                    'question' => $question['question'],
                    'marks' => $question['mark'],
                    'type' => $question['short_type'],
                    'q_group_id' => $question['q_group_id'],
                    'user_id' => Auth::id(),
                    'number_of_option' => 0,
                    'level' => $question['level'],
                    'pre_condition' => $question['pre_condition_type'] == "Yes" ? 1 : 0,
                    'shuffle' => $question['short_type'] == 'M' ? $question['shuffle_off'] == 1 ? 0 : 1 : 0,
                ]);
                $newQus->save();
                $outputIndex = 0;
                $inputIndex = 0;
                $connection = null;

                foreach ((array)$question['options'] as $option) {
                    if ($newQus->type == 'M') {

                        $online_question_option = new QuestionBankMuOption();
                        $online_question_option->question_bank_id = $newQus->id;
                        $online_question_option->title = $option['option'];
                        $online_question_option->status = $option['isCorrect'];
                        $online_question_option->save();
                        $total_options++;

                    } elseif ($newQus->type == 'X') {

                        if (empty($option['option'])) {
                            continue;
                        }
                        $newOption = new QuestionBankMuOption();
                        $newOption->question_bank_id = $newQus->id;
                        $newOption->title = $option['option'];
                        $newOption->status = $option['isCorrect'];
                        $newOption->type = 1;
                        $newOption->save();
                        $total_qus++;
                        $outputIndex++;
//                        outPutIndex-OutputNodeId|inputPutIndex-inPutNodeId
//                        0-1|2-5,1-2|0-3
                        $matchingAns = explode('|', $option['matching']);

                        foreach ($matchingAns as $key => $ans) {
                            if (empty($ans)) {
                                continue;
                            }
                            $newAns = new QuestionBankMuOption();
                            $newAns->question_bank_id = $newQus->id;
                            $newAns->title = $ans;
                            $newAns->status = $option['isCorrect'];
                            $newAns->type = 2;
                            $newAns->save();
                            $total_ans++;
//                            outputIndex + '-' + output_id + '|' + inputIndex + '-' + input_id;
//                            $connection .= $outputIndex . '-' . ($outputIndex + 1) . '|' . $inputIndex . '-' . ($inputIndex + 1) . ',';
                            MatchingTypeQuestionAssign::create([
                                'question_id' => $newQus->id,
                                'option_id' => $newOption->id,
                                'answer_id' => $newAns->id,

                            ]);
                            $inputIndex++;
                        }
                        $assigns = QuestionBankMuOption::select('id', 'type')->where('question_bank_id', $newQus->id)->orderBy('id', 'asc')->get();

                        $qusIndex = 0;
                        $ansIndex = 0;
                        foreach ($assigns as $key => $assign) {
                            $assign->index = $assign->type == 1 ? $qusIndex : $ansIndex;
                            $assign->serial = $key + 1;
                            if ($assign->type == 1) {
                                $qusIndex++;
                            } else {
                                $ansIndex++;
                            }
                        }

                        $matchings = MatchingTypeQuestionAssign::where('question_id', $newQus->id)->orderBy('id', 'asc')->get();
                        foreach ($matchings as $matching) {
                            $qus = $assigns->where('id', $matching->option_id)->first();
                            $ans = $assigns->where('id', $matching->answer_id)->first();
                            $connection .= $qus->index . '-' . $qus->serial . '|' . $ans->index . '-' . $ans->serial . ',';
                        }


                    }
                }

                $number_of_option = QuestionBankMuOption::where('question_bank_id', $newQus->id)->orderBy('id', 'asc')->count();
                $newQus->number_of_option = $number_of_option;

                $newQus->number_of_qus = $total_qus;
                $newQus->number_of_ans = $total_ans;
                $newQus->data = $data;
                $newQus->connection = $connection;
                $newQus->save();
            }

        } catch (\Exception $exception) {
        }


    }

    public function headingRow(): int
    {
        return 1;
    }

//    public function generateDrawFlow()
//    {
//       return $output['drawflow']['Home']['data']=[];
//
//
//
//        {
//            "drawflow":{
//            "Home":{
//                "data":{
//                    "4":{
//                        "id":4,"name":"qus","data":{
//                            "qus":"aa"},"class":"qus","html":"<div class='row  optionType' data-type='qus' data-index='0'><div class='col-lg-12 optionTitle'><div class='input-effect'><input class='primary_input_field name option_title ' placeholder=' Option 0' type='text' name='qus[0]' value='' df-qus autocomplete='off' required></div></div></div>","typenode":false,"inputs":{
//                        },"outputs":{
//                            "output_1":{
//                                "connections":[{
//                                    "node":"6","output":"input_1"},{
//                                    "node":"5","output":"input_1"}]}},"pos_x":82,"pos_y":143},"5":{
//                        "id":5,"name":"ans","data":{
//                            "ans":"cc"},"class":"ans","html":"<div class='row  optionType' data-type='ans' data-index='0'> <div class='col-lg-12 optionTitle'><div class='input-effect'><input class='primary_input_field name ans_title' placeholder=' Answer 0' type='text' name='ans[0]' value='' df-ans autocomplete='off' required></div></div></div>","typenode":false,"inputs":{
//                            "input_1":{
//                                "connections":[{
//                                    "node":"4","input":"output_1"}]}},"outputs":{
//                        },"pos_x":735,"pos_y":284},"6":{
//                        "id":6,"name":"ans","data":{
//                            "ans":"bb"},"class":"ans","html":"<div class='row  optionType' data-type='ans' data-index='1'> <div class='col-lg-12 optionTitle'><div class='input-effect'><input class='primary_input_field name ans_title' placeholder=' Answer 1' type='text' name='ans[1]' value='' df-ans autocomplete='off' required></div></div></div>","typenode":false,"inputs":{
//                            "input_1":{
//                                "connections":[{
//                                    "node":"4","input":"output_1"}]}},"outputs":{
//                        },"pos_x":756,"pos_y":144}}}}}
//    }
}
