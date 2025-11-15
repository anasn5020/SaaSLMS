<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MyCoursePathwayInfo extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $enrolld;

    public function __construct($enrolld)
    {
        $this->enrolld = $enrolld;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $enrolld=$this->enrolld;
        return view(theme('components.my-course-pathway-info'), compact('enrolld'));
    }
}
