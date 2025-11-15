<?php

namespace App\Http\Resources\api\v1\Course\Lesson;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $assigns = null;
        if(!empty($this->assign)){
            foreach($this->assign as $assign){
                $questionBank = null;
                if(!empty($assign->questionBank)){
                    $qb = $assign->questionBank;
                    $questionMu = null;
                    if(!empty($qb->questionMu)){
                        foreach($qb->questionMu as $qMu){
                            $questionMu[] = [
                                "id" => (int)$qMu->id,
                                "title" => (string)$qMu->title,
                                "status" => (int)$qMu->status,
                                "active_status" => (int)$qMu->active_status,
                                "question_bank_id" => (int)$qMu->question_bank_id,
                                "type" => (int)$qMu->type,
                                "option_index" => (int)$qMu->option_index,
                            ];
                        }
                    }
                    $questionBank = [
                        "id" => (int)$qb->id,
                        "type" => (string)$qb->type,
                        "question" =>(string)$qb->question,
                        "marks" => (float)$qb->marks,
                        "trueFalse" => (string)$qb->trueFalse,
                        "suitable_words" => (string)$qb->suitable_words,
                        "number_of_option" => (string)$qb->number_of_option,
                        "active_status" => (int)$qb->active_status,
                        "image" => $qb->image ? (string)asset($qb->image) :'',
                        "explanation" => (string)$qb->explanation,
                        "level" => (int)$qb->level,
                        "pre_condition" => (int)$qb->pre_condition,
                        "number_of_qus" => (int)$qb->number_of_qus,
                        "number_of_ans" => (int)$qb->number_of_ans,
                        "connection" => (string)$qb->connection,
                        "data" => (string)$qb->data,
                        "shuffle" => (int)$qb->shuffle,
                        "question_mu" => $questionMu,
                    ];
                }
                $assigns[] = [
                    "id" => (int)$assign->id,
                    "online_exam_id" => (int)$assign->online_exam_id,
                    "question_bank_id" => (int)$assign->question_bank_id,
                    "question_bank" => $questionBank,
                ];
            }
        }

        return [
            "id" => (int)$this->id,
            "title" => (string)$this->title,
            "percentage" => (int)$this->percentage,
            "instruction" => (string)$this->instruction,
            "status" => (int)$this->status,
            "is_taken" => (int)$this->is_taken,
            "is_closed" => (int)$this->is_closed,
            "is_waiting" => (int)$this->is_waiting,
            "is_running" => (int)$this->is_running,
            "active_status" => (int)$this->active_status,
            "category_id" => (int)$this->category_id,
            "sub_category_id" => (int)$this->sub_category_id,
            "random_question" => (int)$this->random_question,
            "question_time_type" => (int)$this->question_time_type,
            "question_time" => (int)$this->question_time,
            "question_review" => (int)$this->question_review,
            "show_result_each_submit" => (int)$this->show_result_each_submit,
            "multiple_attend" => (int)$this->multiple_attend,
            "group_id" => (int)$this->group_id,
            "show_ans_with_explanation" => (int)$this->show_ans_with_explanation,
            "type" => (int)$this->type,
            "losing_focus_acceptance_number" => (int)$this->losing_focus_acceptance_number,
            "losing_type" => (int)$this->losing_type,
            "show_ans_sheet" => (int)$this->show_ans_sheet,
            "show_score_result" => (int)$this->show_score_result,
            "multiple_attend_count" => (int)$this->multiple_attend_count,
            "default_setting" => (int)$this->default_setting,
            "show_correct_ans_in_ans_sheet" => (int)$this->show_correct_ans_in_ans_sheet,
            "show_only_wrong_ans_in_ans_sheet" => (int)$this->show_only_wrong_ans_in_ans_sheet,
            "show_total_correct_answer" => (int)$this->show_total_correct_answer,
            "total_questions" => (int)$this->total_questions,
            "total_marks" => (int)$this->total_marks,
            "assign" => $assigns,
        ];
    }
}
