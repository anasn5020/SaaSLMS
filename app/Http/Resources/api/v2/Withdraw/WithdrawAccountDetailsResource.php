<?php

namespace App\Http\Resources\api\v2\Withdraw;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawAccountDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($this->payout != 'Bank Payment') {
            $withdraw = [
                'payment_method_image' => $this->payout_icon ? (string)asset($this->payout_icon) : '',
                'acount_email' => (string)$this->payout_email,
            ];
        } else {
            $withdraw['bank_details'] = [
                'bank_name' => (string)$this->bank_name,
                'branch_name' => (string)$this->branch_name,
                'account_number' => (string)$this->bank_account_number,
                'account_holder' => (string)$this->account_holder_name,
            ];
        }

        return [
            'payment_method' => (string)$this->payout,
        ] + $withdraw;
    }
}
