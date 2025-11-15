<?php

namespace Modules\SystemSetting\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;
use function trans;

class StaffUpdateRequest extends FormRequest
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
        $rules = [
            "employee_id" => "required_if:role_type,!=,'system_user'",
            "name" => "required",
            "username" => "sometimes|nullable|numeric|unique:users,username," . $this->user_id,
            "email" => "required|unique:users,email," . $this->user_id,
            "department_id" => "required|numeric",
            "role_id" => "required|numeric",
            'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1',
            'photo' => 'nullable|mimes:jpeg,jpg,png',
            'signature_photo' => 'nullable|mimes:jpeg,jpg,png',
            'password' => 'sometimes|nullable|string|min:8|confirmed'
        ];

//        if ($this->user_id != 1){
//            $rules[ "role_id"]  = "required|nullable";
//        }

        return $rules;
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
