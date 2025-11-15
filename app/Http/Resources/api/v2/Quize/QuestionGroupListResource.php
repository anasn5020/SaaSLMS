<?php

namespace App\Http\Resources\api\v2\Quize;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionGroupListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parent = null;
        if (!empty($this->parent) && isModuleActive('AdvanceQuiz')) {
            $pr = $this->parent;
            $parent = [
                'id' => (int)$pr->id,
                'name' => (string)$pr->title,
            ];
        }

        return [
            'id' => (int)$this->id,
            'group_name' => (string)$this->title,
            'code' => (string)$this->code,
            'parent' => $parent,
        ];
    }
}
