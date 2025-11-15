<?php

namespace App\Repositories;

use App\BillingDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class CommonRepository implements CommonRepositoryInterface
{
    public function billingInfo($type = null): array
    {
        $user = Auth::user() ? Auth::user() : session()->get('membershipUser');
        $data = [];
        if (!$user) {
            return  [];
        }
        $data['profile'] = $user;
        $data['current'] = BillingDetails::where('user_id', $user->id)->latest()->first();
        $data['bills'] = BillingDetails::with('country')->where('user_id', $user->id)
                        ->latest()->get();
        $data['countries'] = DB::table('countries')->select('id', 'name')->get();
        $data['states'] = DB::table('states')->where('country_id', $data['profile']->country)
                            ->where('id', $data['profile']->state)->select('id', 'name')->get();
        $data['cities'] = DB::table('spn_cities')->where('state_id', $data['profile']->state)
                            ->where('id', $data['profile']->city)->select('id', 'name')->get();
        $data['methods'] = PaymentMethod::where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Bank Payment')->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);

        return $data;
    }
}
