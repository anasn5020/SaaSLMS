<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Calendar\Entities\Calendar;

class CalendarView extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
  

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
         return view(theme('components.calendar-view'));
    }
}
