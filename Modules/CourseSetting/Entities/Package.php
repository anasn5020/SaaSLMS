<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;


class Package extends Model
{


    protected $fillable = [];

    protected $casts = [
        'courses' => 'object',

    ];
}
