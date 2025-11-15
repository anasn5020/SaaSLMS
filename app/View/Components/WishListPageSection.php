<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\StudentSetting\Entities\BookmarkCourse;

class WishListPageSection extends Component
{

    public function render()
    {
        $bookmarks = BookmarkCourse::where('user_id', Auth::id())
            ->with('course', 'user', 'course.user', 'course.subCategory', 'course.lessons')->orderBy('id', 'DESC')->get();
        return view(theme('components.wish-list-page-section'), compact('bookmarks'));
    }
}
