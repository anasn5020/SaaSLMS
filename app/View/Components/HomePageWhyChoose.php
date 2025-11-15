<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\FrontendManage\Entities\WhyChoose;

class HomePageWhyChoose extends Component
{

    public function render()
    {
        $options = WhyChoose::all();
        return view(theme('components.home-page-why-choose'), compact('options'));
    }
}
