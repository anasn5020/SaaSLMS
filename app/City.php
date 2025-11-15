<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'spn_cities';

    public function state()
    {
        return $this->belongsTo(State::class)->withDefault();
    }
}
