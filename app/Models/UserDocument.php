<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;

class UserDocument extends Model
{
    protected $guarded = ["id"];


    public function document_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'document');
    }

    public function getDocumentAttribute($value){
        return $value ? (string)asset($value) : (string)$value;
    }

}
