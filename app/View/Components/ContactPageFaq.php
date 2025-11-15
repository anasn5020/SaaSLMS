<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\FrontendManage\Entities\HomePageFaq;

class ContactPageFaq extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $faqs = HomePageFaq::where('status', 1)->orderBy('order', 'asc')->get();
        return view(theme('components.contact-page-faq'), compact('faqs'));
    }
}