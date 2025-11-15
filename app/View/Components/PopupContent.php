<?php

namespace App\View\Components;

use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class PopupContent extends Component
{

    public function render()
    {
        try {
            $popup = \Modules\PopupContent\Entities\PopupContent::getData();
            $modal = false;

             if (isset($popup->status) && $popup->status == 1 && Session::get('ip') == null) {
                Session::put('ip', request()->ip());
                $modal = true;
            }

        } catch (Exception $exception) {
            $modal = false;
            $popup = false;
        }

        return view(theme('components.popup-content'), compact('popup', 'modal'));
    }
}
