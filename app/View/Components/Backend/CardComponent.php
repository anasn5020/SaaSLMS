<?php

namespace App\View\Components\Backend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardComponent extends Component
{
    public $title, $subtitle, $value;

    public function __construct($title, $value, $subtitle = null)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->value = $value;
    }

    public function render()
    {
        return view(backendComponent('card-component'));
    }

}
