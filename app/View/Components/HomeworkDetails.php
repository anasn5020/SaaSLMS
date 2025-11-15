<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Homework\Entities\InfixHomework;
use Modules\Homework\Entities\InfixAssignHomework;

class HomeworkDetails extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $id;
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
            $assign_assignment=InfixAssignHomework::where('student_id',Auth::user()->id)->where('id',$this->id)->first();
            if ($assign_assignment==null) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
            $assignment_info=InfixHomework::where('id',$assign_assignment->assignment_id)->first();
           

         return view(theme('components.homework-details'), compact('assignment_info','assign_assignment'));
    }
}
