<?php

namespace Modules\BankPayment\Http\Controllers;

use App\DepositRecord;
use App\Traits\ImageStore;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\BankPayment\Entities\BankPaymentRequest;
use Modules\OfflinePayment\Http\Controllers\OfflinePaymentController;
use Modules\Organization\Entities\OrganizationFinance;
use Modules\Organization\Events\CourseSellCommissionEvent;

class BankPaymentController extends Controller
{
    use ImageStore, SendNotification;

    public function index()
    {
        $payments = BankPaymentRequest::latest()->get();
        return view('bankpayment::index', compact('payments'));

    }
    public function create()
    {
        return view('bankpayment::create');
    }

    public function store(Request $request)
    {

        try {

            $status =(int) Settings('active_bank_payment_auto_approval');
            $payment = new BankPaymentRequest();
            $payment->user_id = Auth::user()->id ?? 0;
            $payment->bank_name = $request->bank_name;
            $payment->branch_name = $request->branch_name;
            $payment->account_number = $request->account_number;
            $payment->account_holder = $request->account_holder;
            $payment->account_type = $request->type;
            $payment->amount = $request->deposit_amount;
            $payment->status = $status==1?1:0;

            if ($request->hasFile('image')) {
                $payment->image =$this->saveImage($request->file('image'));
            }
            $payment->save();

            if ($payment->status==1){
                 $this->depositWithGateWay($payment->amount,$payment->user_id);
            }else{
                $admin =User::where('role_id', 1)->first();
                \App\Jobs\SendNotification::dispatch('BankDepositRequest', $admin, [
                    'name'=>$admin->name,
                    'request_by'=>Auth::user()->name,
                    'amount'=>$request->deposit_amount,
                    'date'=>showDate(date('Y-m-d')),
                ],[
                    'actionText' =>trans('common.View'),
                    'actionUrl' => route('bankPayment.index'),
                ]);
                Toastr::success(trans('payment.Your request has pending. Please wait for approved'), trans('common.Success'));

            }




            return true;
        } catch (Exception $e) {
            Toastr::error($e->getMessage(), trans('common.Failed'));
            return false;

        }
    }

    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $request = BankPaymentRequest::findOrFail($id);
            $request->status = 1;
            $request->save();


            $result = $this->depositWithGateWay($request->amount, $request->user_id);
            if ($result) {
                return redirect()->back();
            } else {
                return redirect()->back();
            }


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function depositWithGateWay($amount, $user_id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {


            if (Auth::check()) {
                DB::beginTransaction();
                $user = User::find($user_id);
                $user->balance += $amount;
                $user->save();
                $depositRecord = new DepositRecord();
                $depositRecord->user_id = $user->id;
                $depositRecord->method = "Bank Payment";
                $depositRecord->amount = $amount;
                $depositRecord->save();

                if (isModuleActive('Cashback') && $depositRecord) {
                    generateCashback($depositRecord->user_id, $depositRecord->amount, 'recharge', $depositRecord);
                }
                if (isModuleActive('Organization') && $user->isOrganization()) {
                    $data = [
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'status' => true,
                        'type' => OrganizationFinance::$credit,
                        'description' => OrganizationFinance::$deposit_description,
                        'data_type' => OrganizationFinance::$type_deposit,
                        'payment_type' => OrganizationFinance::$payment_completed,
                    ];
                    event(new CourseSellCommissionEvent($data));
                }

                 $this->sendNotification('Bank_Payment', $user, [
                    'amount' => $amount,
                    'currency' => Settings('currency_code'),
                    'time' => now()->format(Settings('active_date_format') . ' H:i:s A')
                ]);


                Toastr::success(trans('common.Operation successful'), trans('common.Success'));

                DB::commit();
                return true;

            } else {
                DB::rollBack();
                Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
                return false;
            }


        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error(trans('frontend.Something Went Wrong'), trans('common.Error'));
            return false;

        }
    }

    public function destroy($id)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $request = BankPaymentRequest::findOrFail($id);

            if ($request->status==1){
                \request()->merge([
                    'user_id' => $request->user_id,
                    'amount' => $request->amount,
                ]);
                (new OfflinePaymentController())->deductBalance(\request());
            }

            $request->delete();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function settings(Request $request)
    {
        UpdateGeneralSetting('active_bank_payment_auto_approval',$request->get('active_bank_payment_auto_approval',0));
        UpdateGeneralSetting('bank_max_fund_deposit',$request->get('bank_max_fund_deposit',0));
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

}
