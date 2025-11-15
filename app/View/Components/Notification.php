<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class Notification extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
            $perpage =  $this->request->input('perpage', 10);

            $page =  $this->request->input('page', 1);

            $all_notifications= Auth::user()->notifications()->paginate($perpage, ['*'], 'page', $page);

         return view(theme('components.notification'), compact('all_notifications'));
    }
}
