<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Noticeboard extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        $user = Auth::user();
        $courseId = $user->studentCourses->pluck('course_id')->toArray();
        $query = \Modules\Noticeboard\Entities\Noticeboard::where('status', 1)->with('noticeType');

        if (isModuleActive('Organization') && !empty($user->organization_id)) {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('id', $user->organization_id);
            });
        }

        $data['noticeboards'] = $query->whereHas('assign', function ($q) use ($courseId, $user) {
            $q->whereIn('course_id', $courseId);
            $q->orWhere('role_id', $user->role_id);
        })->latest()->paginate(10);
        return view(theme('components.noticeboard'), $data);
    }
}
