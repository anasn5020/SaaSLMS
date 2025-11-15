<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;

class MyBlogPageSection extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $blogs = Blog::where(function ($q) {
            $q->where('institute_id', auth()->user()->institute_id)
                ->orWhereNull('institute_id')
                ->orWhere('institute_id',0);

        })->latest()->paginate(10);
        return view(theme('components.my-blog-page-section'), compact('blogs'));
    }
}
