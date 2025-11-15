<?php

namespace Modules\NotificationSetup\Http\Requests;

use App\Traits\ValidationMessage;
use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    use ValidationMessage;

    public function rules()
    {
        return [
            'title' => 'required',
            'type' => 'required',
            'message' => 'required',
            'course' => 'required_if:type,Course Students',
            'user' => 'required_if:type,Single User',
            'specific_users' => 'array|required_if:type,Specific Users',
        ];
    }


    public function authorize()
    {
        return true;
    }
}
