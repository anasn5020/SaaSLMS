<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class GoogleCalendarReminder extends Component
{

    public $title, $data, $time, $duration;

    public function __construct($title, $date, $time, $duration)
    {

        $this->title = $title;
        $this->date = $date;
        $this->time = $time;
        $this->duration = (int)$duration;
    }


    public function render()
    {
        $start_date = Carbon::parse($this->date)->format('Y-m-d') . ' ' . date("H:i:s", strtotime($this->time));
        $start_time = Carbon::parse($start_date)->format("Ymd\THis");
        $end_time = Carbon::parse($start_date)->addMinute((int)$this->duration)->format("Ymd\THis");
        return view(theme('components.google-calendar-reminder'), compact('start_time', 'end_time'));
    }
}
