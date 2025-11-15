<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $banner, $title, $sub_title;

    public function __construct($banner, $title, $subTitle = null)
    {
        $this->banner = $banner;
        $this->title = $title;
        $this->sub_title = $subTitle;
    }


    public function render()
    {
        return view(theme('components.breadcrumb'));
    }
}
