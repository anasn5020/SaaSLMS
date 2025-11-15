<?php

namespace App\Http\Resources\api\v2\Chapter;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChapterListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'chapter_id'    => (int)$this->id,
            'chapter_no'    => (int)$this->chapter_no,
            'chapter_name'  => (string)$this->name
        ];
    }
}
