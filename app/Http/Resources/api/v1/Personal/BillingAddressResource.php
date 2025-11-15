<?php

namespace App\Http\Resources\api\v1\Personal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BillingAddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $country = null;
        if (!empty($this->countryDetails)) {
            $con = $this->countryDetails;
            $country = [
                "id" => (int)$con->id,
                "name" => (string)$con->name,
                "iso3" => (string)$con->iso3,
                "iso2" => (string)$con->iso2,
                "phonecode" => (string)$con->phonecode,
                "currency" => (string)$con->currency,
                "capital" => (string)$con->capital,
                "active_status" => (int)$con->active_status,
            ];
        }

        return [
            "id" => (int)$this->id,
            "tracking_id" => (string)$this->tracking_id,
            "user_id" => (int)$this->user_id,
            "first_name" => (string)$this->first_name,
            "last_name" => (string)$this->last_name,
            "company_name" => (string)$this->company_name,
            "country" => $country,
            "address1" => (string)$this->address1,
            "address2" => (string)$this->address2,
            "state" => (int)$this->state,
            "state_name" => (string)$this->stateDetails->name,
            "city" => (int)$this->city,
            "city_name" => (string)$this->cityDetails->name,
            "zip_code" => (string)$this->zip_code,
            "phone" => (string)$this->phone,
            "email" => (string)$this->email,
            "details" => (string)$this->details,
            "payment_method" => (string)$this->payment_method,
        ];
    }
}
