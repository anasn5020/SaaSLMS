<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HomePageKeyFeatureSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view(theme('components.home-page-key-feature-section'));
    }
}
