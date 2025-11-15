<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Modules\SystemSetting\Entities\Testimonial;

class HomePageTestimonialSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $testimonials = Cache::rememberForever('TestimonialList_' . app()->getLocale() . SaasDomain(), function () {
            return Testimonial::select('body', 'image', 'author', 'profession', 'star')
                ->where('status', '=', 1)
                ->get();
        });
        return view(theme('components.home-page-testimonial-section'), compact('testimonials'));
    }
}
