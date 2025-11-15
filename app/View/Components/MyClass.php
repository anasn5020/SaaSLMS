<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\MyClass\Entities\LmsClass;

class MyClass extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function render()
    {
        $user = auth()->user();
        $classes = LmsClass::with('courses', 'courses.course', 'courses.userInfo')
            ->whereIn('id', $user->classes->where('status',1)->pluck('class_id')->unique())
            ->get();
        return view(theme('components.my-class'), compact('classes'));
    }
}
