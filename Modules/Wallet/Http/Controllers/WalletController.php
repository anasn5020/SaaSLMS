<?php

namespace Modules\Wallet\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\LmsSaas\Entities\SaasCart;
use Modules\Payment\Entities\Checkout;
use Illuminate\Contracts\Support\Renderable;
use Modules\Subscription\Entities\SubscriptionCart;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('wallet::index');
    }

    public function payment($request)
    {


        try {

            $user = Auth::user();
            $checkout = Checkout::where('id', $request->id)->where('tracking', $request->tracking_id)->first();

            if (Settings('hide_multicurrency') == 1) {
                $amount = (float)number_format(convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $checkout->purchase_price), 2);
            } else {
                $amount = $checkout->purchase_price;
            }

            if ($user->balance < $amount) {
                $response['type'] = 'error';
                $response['message'] = 'Insufficient balance';
                return $response;
            } else {
                $newBal = ($user->balance - $amount);
                $user->balance = $newBal;
                $user->save();

                $response['type'] = 'success';
                $response['response'] = [];
                return $response;
            }


        } catch (Exception $e) {
            DB::rollBack();
            $response['type'] = 'error';
            $response['message'] = 'Operation Failed!';
            return $response;

        }
    }

    public function booking($request)
    {


        try {
            if (Settings('hide_multicurrency') == 1) {
                $amount = (float)number_format(convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $request->deposit_amount), 2);
            } else {
                $amount = $request->deposit_amount;
            }

            $user = Auth::user();
            if ($user->balance < $amount) {

                $response['type'] = 'error';
                $response['message'] = 'Insufficient balance';
                return $response;
            } else {
                $newBal = ($user->balance - $amount);
                $user->balance = $newBal;
                $user->save();

                $response['type'] = 'success';
                $response['response'] = [];
                return $response;
            }


        } catch (Exception $e) {
            $response['type'] = 'error';
            $response['message'] = 'Operation Failed!';
            return $response;

        }
    }


    public function subscription($request)
    {


        try {

            $user = Auth::user();
            $price = $request->price;

            if (Settings('hide_multicurrency') == 1) {
                $amount = (float)number_format(convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $price), 2);
            } else {
                $amount = $price;
            }


            if ($user->balance < $amount) {

                $response['type'] = 'error';
                $response['message'] = 'Insufficient balance';
                return $response;
            } else {
                $newBal = ($user->balance - $amount);
                $user->balance = $newBal;
                $user->save();

                $response['type'] = 'success';
                $response['response'] = [];
                return $response;
            }


        } catch (Exception $e) {
            DB::rollBack();
            $response['type'] = 'error';
            $response['message'] = 'Operation Failed!';
            return $response;

        }
    }

    public function saasPlan($request)
    {


        try {

            $user = Auth::user();
            $plan = SaasCart::where('user_id', $user->id)->first();

            if (Settings('hide_multicurrency') == 1) {
                $amount = (float)number_format(convertCurrency(auth()->user()->currency->code ?? Settings('currency_code'), Settings('currency_code'), $plan->price), 2);
            } else {
                $amount = $plan->price;
            }

            if ($user->balance < $amount) {

                $response['type'] = 'error';
                $response['message'] = 'Insufficient balance';
                return $response;
            } else {
                $newBal = ($user->balance - $amount);
                $user->balance = $newBal;
                $user->save();

                $response['type'] = 'success';
                $response['response'] = [];
                return $response;
            }


        } catch (Exception $e) {
            DB::rollBack();
            $response['type'] = 'error';
            $response['message'] = 'Operation Failed!';
            return $response;

        }
    }

    public function returnAmountTowallet($refund_infos)
    {
        try {
            $user = User::find($refund_infos['customer_id']);
            $newBal = $user->balance + $refund_infos['amount'];
            $user->balance = $newBal;
            $user->save();
            $response['type'] = 'success';
            $response['response'] = [];
            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            $response['type'] = 'error';
            $response['message'] = 'Operation Failed!';
            return $response;

        }
    }


}
