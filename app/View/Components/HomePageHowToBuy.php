<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HomePageHowToBuy extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }


    public function render()
    {
        return view(theme('components.home-page-how-to-buy'));
    }
}
