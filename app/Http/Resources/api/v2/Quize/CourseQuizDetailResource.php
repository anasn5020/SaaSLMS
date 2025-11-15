<?php

namespace App\Http\Resources\api\v2\Quize;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseQuizDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        switch ($this->lessonQuiz->question_time_type) {
            case 0:
                $qTimeType = [
                    'id' => (int) $this->lessonQuiz->question_time_type,
                    'name' => (string) 'Per Question Time',
                ];
                break;
            case 1:
                $qTimeType = [
                    'id' => (int) $this->lessonQuiz->question_time_type,
                    'name' => (string) 'Total Question Time',
                ];
                break;

            default:
                $qTimeType = null;
                break;
        }

        return [
            'course_id' => (int) $this->course_id,
            'chapter_id' => (int) $this->chapter_id,
            'quiz_title' => (string) $this->lessonQuiz->title,
            'category' => [
                'id' => (int) $this->lessonQuiz->category->id,
                'name' => (string) $this->lessonQuiz->category->name,
            ],
            'quiz_group' => [
                'id' => (int) $this->lessonQuiz->group->id,
                'name' => (string) $this->lessonQuiz->group->title,
            ],
            'instructions' => (string) $this->lessonQuiz->instruction,
            'min_percentange' => (float) $this->lessonQuiz->percentage,
            'set_random_question' => (bool) $this->lessonQuiz->random_question,
            'num_of_question' => (int) $this->lessonQuiz->total_questions,
            'default_setting' => (bool) $this->lessonQuiz->default_setting,
            'question_time_type' => $qTimeType,
            'time' => (int) $this->lessonQuiz->question_time,
            'questions_review' => (bool) $this->lessonQuiz->question_review,
            'random_question' => (bool) $this->lessonQuiz->random_question,
            'multiple_attend' => (bool) $this->lessonQuiz->multiple_attend,
            'same_page_show_questions_and_explanation' => (bool) $this->lessonQuiz->show_ans_with_explanation,
            'see_answer' => (bool) $this->lessonQuiz->show_ans_sheet,
            'show_correct_ans_in_answer_sheet' => (bool) $this->lessonQuiz->show_correct_ans_in_ans_sheet,
            'show_only_wrong_ans_in_answer_sheet' => (bool) $this->lessonQuiz->show_only_wrong_ans_in_ans_sheet,
            'losing_focus_acceptance_number' => (bool) $this->lessonQuiz->losing_focus_acceptance_number,
        ];
    }
}
