<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Category;
use Modules\FrontendManage\Entities\FrontPage;

class HomePageCategorySlider extends Component
{
    public function render()
    {
        $categories = Category::where('status', 1)->get();
        return view(theme('components.home-page-category-slider'), compact('categories'));
    }
}
