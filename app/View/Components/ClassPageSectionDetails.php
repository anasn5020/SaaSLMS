<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ClassPageSectionDetails extends Component
{
    public $total, $order, $courses;

    public function __construct($total, $order, $courses)
    {
        $this->total = $total;
        $this->order = $order;
        $this->courses = $courses;
    }

    public function render()
    {
        return view(theme('components.class-page-section-details'));
    }
}
