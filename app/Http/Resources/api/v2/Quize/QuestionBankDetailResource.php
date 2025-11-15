<?php

namespace App\Http\Resources\api\v2\Quize;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionBankDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $typeName = getQuestionType($this->type);

        $options = [];
        foreach($this->questionMuInSerial as $option){
            $options[] = [
                'id' => (int)$option->id,
                'option' => (string)$option->title,
            ];
        }
        $answers = [];
        foreach($this->questionMuInSerial->where('type', 2) as $answer){
            $answers[] = [
                'id' => (int)$answer->id,
                'answer' => (string)$answer->title,
            ];
        }
        $correctAnswers = [];
        foreach($this->questionMuInSerial->where('status', 1) as $answer){
            $correctAnswers[] = [
                'id' => (int)$answer->id,
                'answer' => (string)$answer->title,
            ];
        }
        return [
            'id' => (int)$this->id,
            'type_name' => (string)$typeName,
            'type' => (string)$this->type,
            'group' => [
                'id' => (int)$this->questionGroup->id,
                'name' => (string)$this->questionGroup->title,
            ],
            'question_level' => [
                'id' => (int)$this->questionLevel->id,
                'name' => (string)$this->questionLevel->title,
            ],
            'pre_condition_question' => (bool)$this->pre_condition,
            'mark' => (int)$this->marks,
            'shuffle_answer' => (bool)$this->shuffle,
            'question' => (string)$this->question,
            'explanation' => (string)$this->explanation,
            'number_of_option' => (int)$this->number_of_option,
            'option' => $options,
            'answer' => $answers,
            'correct_answer' => $correctAnswers,
            'image' => $this->image ? (string)asset($this->image) : (string)$this->image,
        ];
    }
}
