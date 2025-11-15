<?php

namespace App\Http\Resources\api\v2\Quize;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\AdvanceQuiz\Entities\MatchingTypeQuestionAssign;
use Modules\Quiz\Entities\QuestionBank;

class QuestionListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        if (is_array($this) || is_object($this)) {
            $question = [];
            foreach ($this as $id) {
                $question[] = QuestionBank::find($id);
            }
        } else {
            $question = QuestionBank::find($this);
        }

        return [
            'course_id'                 => (int)$request->course_id,
            'chapter_id'                => (int)$request->chapter_id,
            'quiz_id'                   => (int)$request->quiz_id,
            'question_id'               => (int)$question[0]->id,
            'group'                     => [
                'id'    => (int)$question[0]->questionGroup->id,
                'name'  => (string)$question[0]->questionGroup->title,
            ],
            'question_level'            => [
                'id'    => (int)$question[0]->questionLevel->id,
                'name'  => (string)$question[0]->questionLevel->title,
            ],
            'question_type'             => (string)@$question[0]->type,
            'image'                     => $question[0]->image ? (string)asset($question[0]->image) : '',
            'question'                  => (string)$question[0]->question,
            'pre_condition_question'    => (bool)$question[0]->pre_condition,
            'mark'                      => (float)$question[0]->marks,
            'shuffle_answer'            => (bool)$question[0]->shuffle,
            'explanation'               => (string)$question[0]->explanation,
            'number_of_option'          => (int)$question[0]->number_of_option,
            'options'                   => $question[0]->questionMuInSerial->where('type', 1)->map(function ($option) {
                return [
                    'id'        => (int)$option->id,
                    'option'    => (string)$option->title,
                ];
            }),
            'answers'                   => $question[0]->questionMuInSerial->where('type', 2)->map(function ($option) {
                return [
                    'id'        => (int)$option->id,
                    'answer'    => (string)$option->title,
                ];
            }),
        ];
    }
}
