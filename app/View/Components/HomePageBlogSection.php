<?php

namespace App\View\Components;

use App\Traits\Tenantable;
use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;
use Illuminate\Support\Facades\Cache;

class HomePageBlogSection extends Component
{
    use Tenantable;

    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $blogs = Cache::rememberForever('BlogPosList_' . app()->getLocale() . SaasDomain(), function () {
            return Blog::where('status', 1)
                ->with('user')
                ->latest()
                ->take(4)
                ->get();
        });
        return view(theme('components.home-page-blog-section'), compact('blogs'));
    }
}
