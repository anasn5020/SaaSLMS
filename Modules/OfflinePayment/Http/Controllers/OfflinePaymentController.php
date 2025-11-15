<?php

namespace Modules\OfflinePayment\Http\Controllers;

use App\DepositRecord;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OfflinePayment\Entities\OfflinePayment;

class OfflinePaymentController extends Controller
{

    use SendNotification;

    public function offlinePaymentView()
    {
        $users = User::select(['id','name','email','balance','image','status','role_id'])->where('status', 1)->get();
        $instructor = $users->where('role_id', 2);
        $student = $users->where('role_id', 3);
        return view('offlinepayment::fund.add_fund', compact('student', 'instructor'));
    }

    public function FundHistory($id)
    {

        try {
            $user = User::with('currency')->where('id', $id)->first();
            $payments = OfflinePayment::where('user_id', $id)->with('user.role')->get();
            return view('offlinepayment::fund.funding_history', compact('payments', 'user'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function addBalance(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
        ]);

        try {

            $user = User::where('id', $request->user_id)->first();
            $tran = new OfflinePayment();
            $new = $user->balance + $request->amount;
            $tran->user_id = $user->id;
            $tran->role_id = $user->role_id;
            $tran->amount = $request->amount;
            $tran->status = 1;
            $tran->after_bal = $new;
            $tran->save();
            $user->balance = $new;
            $user->save();

            $depositRecord = new DepositRecord();
            $depositRecord->user_id = $user->id;
            $depositRecord->method = 'Offline Payment';
            $depositRecord->amount = $request->amount;
            $depositRecord->save();
            if ($user->role_id == 3) {
                $isStudent = true;
            } else {
                $isStudent = false;
            }

            $this->sendNotification('OffLine_Payment', $user, [
                'amount' => $request->amount,
                'currency' => Settings('currency_code'),
                'time' => now()->format(Settings('active_date_format') . ' H:i:s A'),
            ]);

            $this->sendNotification('Wallet_Credited', $user, [
                'name' => $user->name,
                'amount' => $request->amount,
                'date_time' => Carbon::now()->format(Settings('active_date_format') . ' H:i:s A'),
            ]);


            Toastr::success(trans('common.Fund Added'), trans('common.Success'));
            return back()->with('isStudent', $isStudent);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function deductBalance(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
        ]);

        try {

            $user = User::where('id', $request->user_id)->first();
            if ($user->role_id == 3) {
                $isStudent = true;
            } else {
                $isStudent = false;
            }

            if ($user->balance < $request->amount) {
                Toastr::error(trans('common.Insufficient balance'), trans('common.Error'));
                return redirect()->back();
            }

            $tran = new OfflinePayment();
            $new = $user->balance - $request->amount;
            $tran->user_id = $user->id;
            $tran->role_id = $user->role_id;
            $tran->amount = $request->amount;
            $tran->status = 1;
            $tran->after_bal = $new;
            $tran->type = 'Deduct';
            $tran->save();
            $user->balance = $new;
            $user->save();

            $depositRecord = new DepositRecord();
            $depositRecord->user_id = $user->id;
            $depositRecord->method = 'Offline Payment';
            $depositRecord->amount = -abs($request->amount);
            $depositRecord->save();

            $this->sendNotification('Deduct_Payment', $user, [
                'amount' => getPriceFormat($request->amount),
                'time' => now()->format(Settings('active_date_format') . ' H:i:s A'),
            ]);

            Toastr::success(trans('payment.Deduct') . ' ' . trans('payment.Fund'), trans('common.Success'));
            return back()->with('isStudent', $isStudent);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }


}
