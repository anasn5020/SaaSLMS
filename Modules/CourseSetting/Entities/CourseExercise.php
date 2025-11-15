<?php

namespace Modules\CourseSetting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\UsedMedia;

class CourseExercise extends Model
{


    protected $fillable = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($exercise) {
            $file = $exercise->file;
            $filesize = filesize($file); // bytes
            // $filesize = round($filesize / 1024 / 1024, 1); //MB
            $filesize = round($filesize / 1024, 2); //KB

            $exercise->old_file_size = $filesize;
            $exercise->file_size = $filesize;
            $exercise->save();
            if (isModuleActive('LmsSaas')) {
                saasPlanManagement('upload_limit', 'create', $filesize);
            }
        });
        self::deleting(function ($exercise) {
            saasPlanManagement('upload_limit', 'delete', $exercise->filesize);
        });
    }

    public function file_media()
    {
        return $this->morphOne(UsedMedia::class, 'usable')->where('used_for', 'file');
    }

}
