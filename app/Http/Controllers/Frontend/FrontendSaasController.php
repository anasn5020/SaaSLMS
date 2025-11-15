<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\LmsSaas\Entities\SaasCart;
use Modules\LmsSaas\Entities\SaasPlan;
use Modules\LmsSaasMD\Entities\SaasCart as SaasCartMD;
use Modules\LmsSaasMD\Entities\SaasPlan as SaasPlanMD;

class FrontendSaasController extends Controller
{
    public function index()
    {
        if (isModuleActive('LmsSaas') || isModuleActive('LmsSaasMD')) {
            return view(theme('pages.saas_plans'));
        } else {
            Toastr::error(trans('frontend.Module not active'), trans('common.Error'));

            return redirect()->back();
        }
    }

    public function saasCheckout(Request $request)
    {
        // return $request;
        if (empty($request->plan)) {
            $s_plan = '';
        } else {
            $s_plan = $request->plan;
        }

        if (empty($request->price)) {
            $price = 0;
        } else {
            $price = $request->price;
        }

        if (!empty($s_plan)) {
            if ((isModuleActive('LmsSaas') || isModuleActive('LmsSaasMD')) && Auth::check()) {
                if (Auth::user()->role_id == 1) {
                    $addCart = $this->addToCart(Auth::user()->id, $s_plan);
                    if (!$addCart) {
                        Toastr::error(trans('frontend.Invalid Request'), trans('common.Failed'));

                         return \redirect()->route('saasPackages');
                    }
                } else {
                    Toastr::error(trans('frontend.You must login as a lms admin'), trans('common.Failed'));

                     return \redirect()->route('lms_register');
                }

            } else {
                Toastr::error(trans('frontend.You must login'), trans('common.Error'));

                 return \redirect()->route('login');
            }
        } else {
            Toastr::error(trans('frontend.Invalid Request'), trans('common.Error'));

             return \redirect()->route('login');
        }


        return view(theme('pages.saasCheckout'), compact('request', 's_plan', 'price'));

    }

    public function addToCart($user_id, $plan_id)
    {
        if (demoCheck()) {
            return false;
        }
        if (!Auth::check()) {
            Toastr::error(trans('frontend.You must login'), trans('common.Error'));
            return false;
        }
        if (Auth::user()->role_id != 1) {
            Toastr::error(trans('frontend.You must login as a lms admin'), trans('common.Failed'));
            return false;


        }
        if (isModuleActive('LmsSaas')) {
            $cart = SaasCart::on(config('database.default'))->where('user_id', $user_id)->first();
            $plan = SaasPlan::on(config('database.default'))->find($plan_id);
        } else {
            $cart = SaasCartMD::on(config('database.default'))->where('user_id', $user_id)->first();
            $plan = SaasPlanMD::on(config('database.default'))->find($plan_id);
        }

        if (empty($plan)) {
            Toastr::error(trans('frontend.Invalid Plan'), trans('common.Failed'));

             return false;
        }
        if (!$cart) {

            if (isModuleActive('LmsSaas')) {
                $cart = new SaasCart();
            } else {
                $cart = new SaasCartMD();
            }
        }
        $cart->user_id = $user_id;
        $cart->plan_id = $plan_id;
        $cart->tracking = getTrx(20);;
        $cart->price = $plan->price;
        $cart->days = $plan->days;
        $cart->save();
        return true;
    }
}
