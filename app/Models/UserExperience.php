<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserExperience extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function duration()
    {
        if($this->currently_working && $this->start_date){
            return Carbon::now()->diffForHumans($this->start_date,CarbonInterface::DIFF_ABSOLUTE, false, 2);
        }else if($this->start_date && $this->end_date ){
            return Carbon::parse($this->end_date)->diffForHumans($this->start_date,CarbonInterface::DIFF_ABSOLUTE, false, 2);
        }else{
            return '';
        }
    }
}
