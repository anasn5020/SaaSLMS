<?php

namespace Modules\Setting\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;

class SmsGatewayRequest extends FormRequest
{
    use ValidationMessage;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gateway_name' => 'required',
            'gateway_url' => 'required|url',
            'request_method' => 'required',
            'set_auth' => 'required',
            'add_plus' => 'nullable',
            'send_to_parameter_name' => 'required',
            'message_to_parameter_name' => 'required',
            'gateway_logo' => 'nullable|mimes:jpeg,bmp,png,jpg,svg,gif',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
