<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class SubCategory extends Model
{


    protected $fillable = [
        'category_id', 'name', 'status', 'show_home', 'position_order',
    ];


    public function category()
    {

        return $this->belongsTo(Category::class)->withDefault();
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'subcategory_id');
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->name) == "" ? str_replace(' ', '-', $this->name) : Str::slug($this->name);

    }

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('categories');
        });
        self::updated(function ($model) {
            Cache::forget('categories');
        });
    }
}
