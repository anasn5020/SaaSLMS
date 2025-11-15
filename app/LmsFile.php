<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LmsFile extends Model
{
    protected $fillable=['fileable_id','fileable_type','file_name'];

    public function fileable(){
        return $this->morphTo();
    }
}
