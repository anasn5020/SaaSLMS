<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use Modules\SkillAndPathway\Entities\StudentSkill;

class MySkill extends Component
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
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $skills = StudentSkill::where('student_id',Auth::id())->with('skill_info')->get();
         return view(theme('components.my-skill'), compact('skills'));
    }
}
