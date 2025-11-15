<?php

namespace Modules\SystemSetting\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;
use function trans;

class StaffRequest extends FormRequest
{
    use ValidationMessage;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == "POST") {
            return [
                "employee_id" => "required_if:role_type,!=,'system_user'",
                "name" => "required",
                "username" => "sometimes|nullable|numeric|unique:users,username",
                "email" => "required|unique:users,email",
                "password" => "required|min:8",
                "department_id" => "required|numeric",
                "role_id" => "required|numeric",
                'photo' => 'nullable|mimes:jpeg,jpg,png',
                'signature_photo' => 'nullable|mimes:jpeg,jpg,png',
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',

            ];

        } else {
            return [
                "employee_id" => "required_if:role_type,!=,'system_user'",
                "name" => "required",
                "username" => "sometimes|nullable|numeric|unique:users,username," . $this->user_id,
                "email" => "required|unique:users,email," . $this->user_id,
                "password" => "required|min:8",
                "department_id" => "required|numeric",
                "role_id" => "required|numeric",
                'photo' => 'nullable|mimes:jpeg,jpg,png',
                'signature_photo' => 'nullable|mimes:jpeg,jpg,png',
                'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users',

            ];
        }

    }

    /**
     * Translate fields with user friendly name.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'username' => trans('retailer.Phone'),
        ];
    }
}
