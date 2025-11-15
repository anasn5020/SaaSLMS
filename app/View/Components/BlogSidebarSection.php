<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Entities\BlogCategory;

class BlogSidebarSection extends Component
{
    public $tags = [], $category = '';

    public function __construct($tag = null)
    {
        if (!empty($tag)) {
            $this->tags = explode(',', $tag);
        }

        $this->category =request('category');
    }


    public function render()
    {
        $tags = $this->tags;
        $categories = BlogCategory::where('status', 1)->get();
        $query = Blog::with('category')->where('status', 1);

          if (Auth::check() && Auth::user()->role_id != 1) {
              $query->where(function ($q) {
                  $institute_id = Auth::check() ? Auth::user()->institute_id : 0;
                  $q->whereNull('institute_id')->orWhere('institute_id', $institute_id);
              });
          }

        $latestPosts =$query->take(3)->latest()->get();
        return view(theme('components.blog-sidebar-section'), compact('categories', 'latestPosts', 'tags'));
    }
}
