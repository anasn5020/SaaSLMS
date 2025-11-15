<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Homework\Entities\InfixAssignHomework;

class MyHomework extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $homework_list = InfixAssignHomework::where('student_id', Auth::user()->id)
            ->latest()->paginate(5);
        return view(theme('components.my-homework'), compact('homework_list'));
    }
}
