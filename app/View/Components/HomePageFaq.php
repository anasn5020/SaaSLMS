<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\FrontendManage\Entities\HomePageFaq as Faq;

class HomePageFaq extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $faqs = Faq::where('status', 1)->orderBy('order', 'asc')->get();
        return view(theme('components.home-page-faq'), compact('faqs'));
    }
}
