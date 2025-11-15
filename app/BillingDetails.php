<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingDetails extends Model
{
    protected $connection;

    protected $guarded = [];

    protected $casts = [
        'city' => 'integer',
    ];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        if (isModuleActive('LmsSaasMD') && SaasDomain() != "main") {
            $this->setConnection('mysql_md');
        } else {
            $this->setConnection(config('database.default'));
        }
    }


    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country')->withDefault();
    }

    public function countryDetails()
    {
        return $this->belongsTo(Country::class, 'country')->withDefault();
    }

    public function stateDetails()
    {
        return $this->belongsTo(State::class, 'state')->withDefault();
    }

    public function cityDetails()
    {
        return $this->belongsTo(City::class, 'city')->withDefault();
    }
}
