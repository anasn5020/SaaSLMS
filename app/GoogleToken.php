<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoogleToken extends Model
{
    protected $fillable = ['user_id','google_email','refresh_token','token','expires_in','backup_folder_id','backup_folder_name','attendance_folder_id','attendance_folder_name','attendance_id'];
}
