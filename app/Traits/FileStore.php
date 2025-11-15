<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;


trait FileStore
{

    public static function saveFile(UploadedFile $file)
    {
        if(isset($file)){
            $current_date  = Carbon::now()->format('d-m-Y');

            if(!File::isDirectory('uploads/file/'.$current_date)){
                File::makeDirectory('uploads/file/'.$current_date, 0777, true, true);
            }

            $file_name = uniqid().'.'.$file->extension();
            $file->storeAs('uploads/file/'.$current_date.'/', $file_name);
            return 'uploads/file/'.$current_date.'/'.$file_name;
        }else{
            return null ;
        }
    }
}
