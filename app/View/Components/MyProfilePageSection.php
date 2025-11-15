<?php

namespace App\View\Components;

use App\StudentCustomField;
use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MyProfilePageSection extends Component
{

    public function render()
    {
        $profile = Auth::user();
        $countries = DB::table('countries')->select('id', 'name')->get();
        $query = DB::table('states')->where('country_id', $profile->country);
        if (!empty($profile->state)) {
            $query->where('id', $profile->state);
        }

        $states = $query->select('id', 'name')->get();
        $query2 = DB::table('spn_cities');
        if (!empty($profile->state)) {
            $query2->where('state_id', $profile->state);
        }
        if (!empty($profile->city)) {
            $query2->where('id', $profile->city);
        }
        if (empty($profile->state)) {
            $cities = [];
        } else {
            $cities = $query2->select('id', 'name')->get();
        }
        $custom_field = StudentCustomField::getData();

        $langs = DB::table('languages')
            ->select('id', 'native', 'code', 'rtl')
            ->where('status', '=', 1)
            ->get();

        return view(theme('components.my-profile-page-section'), compact('profile', 'countries', 'cities', 'langs', 'custom_field', 'states'));
    }
}
