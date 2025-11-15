<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AboutPageWhoWeAre extends Component
{
    public $who_we_are, $banner_title;

    public function __construct($whoWeAre, $bannerTitle)
    {
        $this->who_we_are = $whoWeAre;
        $this->banner_title = $bannerTitle;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view(theme('components.about-page-who-we-are'));
    }
}
