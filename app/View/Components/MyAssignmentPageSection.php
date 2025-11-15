<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Assignment\Entities\InfixAssignAssignment;

class MyAssignmentPageSection extends Component
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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $assignment_list=InfixAssignAssignment::where('student_id',Auth::user()->id)->latest()->paginate(5);
        return view(theme('components.my-assignment-page-section'), compact('assignment_list'));
    }
}
