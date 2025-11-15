<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }
}
