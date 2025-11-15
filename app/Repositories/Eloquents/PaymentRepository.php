<?php

namespace App\Repositories\Eloquents;

use App\Traits\SendNotification;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\ValidationException;
use Modules\Payment\Entities\Withdraw;
use Modules\Payment\Entities\InstructorTotalPayout;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Http\Resources\api\v2\Withdraw\WithdrawListResource;
use App\Http\Resources\api\v2\Withdraw\WithdrawAccountDetailsResource;

class PaymentRepository implements PaymentRepositoryInterface
{
    use SendNotification;
    public function totalEarning(): array
    {
        $nextPayout = InstructorTotalPayout::where('instructor_id', auth()->id())->sum('amount');
        // $totalEarning = InstructorPayout::where('instructor_id', auth()->id())->where('status', 0)->sum('reveune');
        $totalEarning = auth()->user()->balance;

        $data['total_earning'] = (float) $totalEarning;
        $data['next_payout'] = (float) $nextPayout;
        $data['payout_account'] = new WithdrawAccountDetailsResource(auth()->user());

        return $data;
    }

    public function paymentList(object $request): object
    {
        $payoutList = Withdraw::where('instructor_id', auth()->id())
            ->when($search = $request->search, function ($query) use ($search) {
                $query->whereLike('method', $search);
            })->when($request->sort_by_date, function ($query) {
                $query->latest('created_at');
            })->paginate($request->get('per_page', 10));

        return WithdrawListResource::collection($payoutList);
    }

    public function paymentMethods(): object
    {
        $dontShow = ['Offline Payment', 'Bank Payment', 'Wallet', 'Mollie'];
        return PaymentMethod::where('module_status', 1)->where('active_status', 1)
            ->whereNotIn('method', ['Offline Payment', 'Wallet'])
            ->get()
            ->map(function ($method) {
                return [
                    'id' => (int) $method->id,
                    'name' => (string) $method->method,
                    'image' => $method->logo ? (string) asset($method->logo) : '',
                ];
            });
    }

    public function savePayout(object $request): bool
    {
        $method = PaymentMethod::where('method', $request->payment_method)->first();

        $request->merge([
            'payout' => $request->payment_method,
            'payout_icon' => $method->logo
        ]);

        $user = User::find(auth()->id());
        $user->payout = $request->payout;
        if ($request->payout == "Bank Payment") {
            $user->bank_name = $request->bank_name;
            $user->branch_name = $request->branch_name;
            $user->bank_account_number = $request->bank_account_number;
            $user->account_holder_name = $request->account_holder_name;
            $user->bank_type = $request->bank_type;
            $user->payout_icon = '';
            $user->payout_email = '';
            if (isModuleActive('Bkash')) {
                $user->bkash_number = '';
            }
        } elseif ($request->payout == "Bkash") {
            $user->bank_name = '';
            $user->branch_name = '';
            $user->bank_account_number = '';
            $user->account_holder_name = '';
            $user->bank_type = '';
            if (isModuleActive('Bkash')) {
                $user->bkash_number = $request->payout_number;
            }
            $user->payout_icon = $request->payout_icon;
            $user->payout_email = '';
        } else {
            $user->bank_name = '';
            $user->branch_name = '';
            $user->bank_account_number = '';
            $user->account_holder_name = '';
            $user->bank_type = '';
            if (isModuleActive('Bkash')) {
                $user->bkash_number = '';
            }
            $user->payout_icon = $request->payout_icon;
            $user->payout_email = $request->payout_email;
        }
        $user->save();

        return true;
    }

    public function instructorRequestPayout(object $request): bool
    {
        $user = auth()->user();
        $totalPayout = InstructorTotalPayout::where('instructor_id', $user->id)->first();
        $maxAmount = $totalPayout->amount;
        $amount = $request->amount;

        if ($maxAmount < $amount) {
            throw ValidationException::withMessages(['message' => 'Insufficient balance.']);
        }
        try {
            $withdraw = new Withdraw();
            $withdraw->instructor_id = auth()->user()->id;
            $withdraw->amount = $amount;
            $withdraw->issueDate = Carbon::now();
            $withdraw->method = auth()->user()->payout;
            $withdraw->save();
            $totalPayout->amount = $totalPayout->amount - $amount;
            $totalPayout->save();

            if (auth()->user()->role_id != 1) {
                $admins = User::where('role_id', 1)->get();
                foreach ($admins as $user) {

                    $this->sendNotification('PayoutRequest',$user,[
                        'admin' => $user->name,
                        'amount' => $amount,
                        'instructor' => auth()->user()->name,
                    ]);
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
