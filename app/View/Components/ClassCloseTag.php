<?php

namespace App\View\Components;

use Carbon\Carbon;
use Illuminate\View\Component;

class ClassCloseTag extends Component
{
    private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }


    public function render()
    {
        $class = $this->class;
        $last_time = Carbon::parse($class->end_date . ' ' . $class->time);
        $last_time->addMinutes((int)$class->duration);
        $nowDate = Carbon::now();
        $isWaiting = $last_time->gt($nowDate);
        return view(theme('components.class-close-tag'), compact('isWaiting'));
    }
}
