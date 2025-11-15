<?php

namespace App\Http\Controllers\Api\V2\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PaymentRepositoryInterface;

class PaymentController extends Controller
{
    private $paymentRepository;
    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }
    public function totalEarning(): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->paymentRepository->totalEarning(),
            'message'   => trans('api.Operation successful')
        ]);
    }
    public function paymentList(Request $request): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->paymentRepository->paymentList($request),
            'message'   => trans('api.Getting payment history successfully')
        ]);
    }
    public function paymentMethods(): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->paymentRepository->paymentMethods(),
            'message'   => trans('api.Getting payment method list successfully'),
        ]);
    }
    public function savePayout(Request $request): object
    {
        if (demoCheck()) {
            return response()->json(['success' => false, 'message' => 'Your are not allowed for this action'],403);
        }
        if ($request->payment_method == "Bank Payment") {
            $rules = [
                'bank_name' => 'required',
                'branch_name' => 'required',
                'bank_account_number' => 'required',
                'account_holder_name' => 'required',
                'bank_type' => 'required',
            ];
        } elseif ($request->payment_method == "Bkash") {
            $rules = [
                'payout_number' => 'required',
            ];
        } else {
            $rules = ['payout_email' => 'required|email'];
        }
        $request->validate($rules, validationMessage($rules));

        $this->paymentRepository->savePayout($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Payout account added successfully'),
        ]);
    }

    public function instructorRequestPayout(Request $request)
    {
        if(demoCheck()){
            return response()->json(['message' => trans('api.For the demo version, you cannot change this')],403);
        }

        if($this->paymentRepository->instructorRequestPayout($request)){
            return response()->json([
                'success'   => true,
                'message'   => trans('lang.Payment request has been successfully submitted'),
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'message'   => trans('api.Something went worng'),
            ],400);
        }
    }
}
