<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\FrontendManage\Entities\Slider;

class HomePageBanner extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }


    public function render()
    {
        $sliders = null;
        if ($this->homeContent->show_banner_section == 0) {
            $sliders = Slider::where('status', 1)->get();
        }
        return view(theme('components.home-page-banner'), compact('sliders'));
    }
}
