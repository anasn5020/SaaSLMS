<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;

class PopulerInstractor extends Component
{
    public function render()
    {
        $instructors = User::whereIn('role_id', [1, 2])
//            ->With('totalRating')
            ->withCount('totalSellCourse', 'courses', 'totalReview')
            ->orderBy('total_sell_course_count', 'desc')
            ->take(3)->get();
        return view(theme('components.populer-instractor'), compact('instructors'));
    }
}
