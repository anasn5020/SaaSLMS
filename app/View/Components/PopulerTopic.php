<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\CourseSetting\Entities\Category;

class PopulerTopic extends Component
{
    public function render()
    {
        $query = Category::where('status', 1);
        $query->withCount('totalEnrolled')->orderBy('total_enrolled_count', 'desc');
        $categories = $query->limit(12)->get();
        return view(theme('components.populer-topic'), compact('categories'));
    }
}
