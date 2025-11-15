<?php

namespace App\Http\Resources\api\v1\Personal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => (int)$this->id,
            "role_id" => (int)$this->role_id,
            "student_group_id" => (int)$this->student_group_id,
            "student_type" => (string)$this->student_type,
            "name" => (string)$this->name,
            "first_name" => (string)$this->first_name,
            "last_name" => (string)$this->last_name,
            "about" => (string)$this->about,
            "photo" => $this->photo ? (string)asset($this->photo) : '',
            "image" => $this->image ? (string)asset($this->image) : '',
            "avatar" => $this->avatar ? (string)asset($this->avatar) : '',
            "username" => (string)$this->username,
            "email" => (string)$this->email,
            "email_verify" => (int)$this->email_verify,
            "headline" => (string)$this->headline,
            "phone" => (string)$this->phone,
            "address" => (string)$this->address,
            "country" => (int)$this->country,
            "country_name" => (string)$this->country_name,
            "state" => (int)$this->state,
            "state_name" => (string)$this->state_name,
            "city" => (int)$this->city,
            "city_name" => (string)$this->city_name,
            "zip" => (string)$this->zip,
            "language_id" => (string)$this->language_id,
            "language_code" => (string)$this->language_code,
            "language_name" => (string)$this->language_name,
            "language_rtl" => (int)$this->language_rtl,
            "subscribe" => (int)$this->subscribe,
            "status" => (int)$this->status,
            "balance" => (float)$this->balance,
            "currency_id" => (int)$this->currency_id,
            "currency_symbol" => (string)$this->currency_symbol,
            "currency_code" => (string)$this->currency_code,
            "bank_name " => (string)$this->bank_name,
            "branch_name" => (string)$this->branch_name,
            "bank_account_number" => (string)$this->bank_account_number,
            "account_holder_name" => (string)$this->account_holder_name,
            "bank_type" => (string)$this->bank_type,
            "device_token" => (string)$this->device_token,
            "otp" => (string)$this->otp,
            "referral" => (string)$this->referral,
        ];
    }
}
