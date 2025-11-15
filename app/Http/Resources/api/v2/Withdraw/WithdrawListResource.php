<?php

namespace App\Http\Resources\api\v2\Withdraw;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;

class WithdrawListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $paymentMethod = PaymentMethod::where('method',$this->method)->first();

        return [
            'id'                    => $this->id,
            'date'                  => $this->invoiceDate,
            'payment_method'        => $this->method,
            'payment_method_image'  => $paymentMethod?->logo ? (string)asset($paymentMethod->logo) : '',
            'status'                => $this->status == 1 ? ucwords('paid') : ucwords('pending'),
            'paid_amount'           => (float)$this->amount
        ];
    }
}
