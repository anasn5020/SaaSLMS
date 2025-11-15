<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InstructorReview extends Component
{

    public $id;
    public $user;
    public function __construct($id, $user)
    {
        $this->user = $user;
        $this->id = $id;
    }


    public function render()
    {
        $data['instructorReviews'] = $this->user->instructorReview;
        return view('components.instructor-review', $data);
    }
}
