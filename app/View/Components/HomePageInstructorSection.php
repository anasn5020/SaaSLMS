<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;

class HomePageInstructorSection extends Component
{
    public $homeContent;

    public function __construct($homeContent)
    {
        $this->homeContent = $homeContent;
    }

    public function render()
    {
        $data = [];

        if (currentTheme() == "teachery") {
            $data['instructors'] = User::where('role_id', 2)->where('status', 1)->take(9)->get();
        }
        return view(theme('components.home-page-instructor-section'), $data);
    }
}
