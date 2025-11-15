<?php

namespace App\Http\Resources\api\v2\Quize;

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
        $category = null;
        if (!empty($this->category)) {
            $cat = $this->category;
            $category = [
                "id"=> (int)$cat->id,
                "name"=> (string)$cat->name,
            ];
        }

        $group = null;
        if (!empty($this->group)) {
            $group = $this->group;
            $group = [
                "id"=> (int)$group->id,
                "name"=> (string)$group->title,
            ];
        }

        switch ($this->question_time_type) {
            case 0:
                $qTimeType = [
                    'id' => (int) $this->question_time_type,
                    'name' => (string) 'Per Question Time',
                ];
                break;
            case 1:
                $qTimeType = [
                    'id' => (int) $this->question_time_type,
                    'name' => (string) 'Total Question Time',
                ];
                break;

            default:
                break;
        }

        $losingType = null;
        if ($this->losing_focus_acceptance_number) {
            switch ($this->losing_type) {
                case 0:
                    $losingType = [
                        'id' => (int) $this->losing_type,
                        'name' => (string) 'Per Question Time',
                    ];
                    break;
                case 1:
                    $losingType = [
                        'id' => (int) $this->losing_type,
                        'name' => (string) 'Total Question Time',
                    ];
                    break;

                default:
                    break;
            }
        }

        return [
            "quiz_id" => (int)$this->id,
            "quiz_title" => (string)$this->title,
            "category" => $category,
            "quiz_group" => $group,
            "instructions" => (string)$this->instruction,
            "min_percentange" => (float)$this->percentage,
            "set_random_question" => (bool)$this->random_question,
            "num_of_question" => (int)$this->total_questions,
            "default_setting" => (bool)$this->default_setting,
            "question_time_type" => $qTimeType,
            "time" => (int) $this->question_time,
            'questions_review' => (bool) $this->question_review,
            'random_question' => (bool) $this->random_question,
            'multiple_attend' => (bool) $this->multiple_attend,
            'same_page_show_questions_and_explanation' => (bool) $this->show_ans_with_explanation,
            'see_answer' => (bool) $this->show_ans_sheet,
            'show_correct_ans_in_answer_sheet' => (bool) $this->show_correct_ans_in_ans_sheet,
            'show_only_wrong_ans_in_answer_sheet' => (bool) $this->show_only_wrong_ans_in_ans_sheet,
            "losing_focus_acceptance" => (bool) $this->losing_focus_acceptance_number,
            "losing_type" => $losingType,
            "total_question_time_count" => (int)$this->losing_focus_acceptance_number,
        ];
    }
}
