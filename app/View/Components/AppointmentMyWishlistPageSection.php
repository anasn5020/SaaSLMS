<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Appointment\Entities\AppointmentSettings;
use Modules\Appointment\Entities\Wishlist;

class AppointmentMyWishlistPageSection extends Component
{

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
        $data = [];
        $data['request'] = $this->request;
        if (auth()->check()) {
            $data['wishlists'] = Wishlist::where('user_id', auth()->user()->id)->get();
            $data['settings'] = AppointmentSettings::first();
        }
        return view(theme('components.appointment-my-wishlist-page-section'), $data);
    }
}
