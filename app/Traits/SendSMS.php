<?php

namespace App\Traits;

use Brian2694\Toastr\Toastr;
use Modules\Setting\Entities\SmsGateway;
use Twilio\Rest\Client;
use Modules\Setting\Model\BusinessSetting;

trait SendSMS
{
    public function sendIndividualSMS($number, $text)
    {
        $apy_key = env('SMS_API_KEY');

        try {
            $soapClient = new \SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");
            $paramArray = array(
                'apiKey' => $apy_key,
                'messageText' => $text,
                'numberList' => $number,
                'smsType' => "TEXT",
                'maskName' => '',
                'campaignName' => '',
            );
            $value = $soapClient->__call("NumberSms", array($paramArray));
            return $value;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    function sendSMS($to, $from, $text)
    {
        if (BusinessSetting::where('type', 'twillo_sms_gateway')->first()->status) {
            $sid = env("TWILIO_SID"); // Your Account SID from www.twilio.com/console
            $token = env("TWILIO_TOKEN"); // Your Auth Token from www.twilio.com/console

            $client = new Client($sid, $token);
            try {
                $message = $client->messages->create(
                    $to, // Text this number
                    array(
                        'from' => env('VALID_TWILLO_NUMBER'), // From a valid Twilio number
                        'body' => $text
                    )
                );
            } catch (\Exception $e) {

            }
        } elseif (BusinessSetting::where('type', 'text_to_local_sms')->first()->status) {
            // Account details
            $apiKey = urlencode(env('TEXT_TO_LOCAL_API_KEY'));

            // Message details
            $numbers = array($to);
            $sender = urlencode(env('TEXT_TO_LOCAL_SENDER'));
            $message = rawurlencode($text);

            $numbers = implode(',', $numbers);

            // Prepare data for POST request
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

            // Send the POST request with cURL
            $ch = curl_init('https://api.txtlocal.com/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Process your response here
            return $response;
        }

    }


    public function send_test_sms($receiver_number, $message)
    {

        $active_gateway = SmsGateway::where('status', 1)->first();
        if (!$active_gateway) {
            Toastr::info(trans('setting.No Active Gateway'));
            return false;
        }
        if (empty($active_gateway->gateway_url)) {
            Toastr::info(trans('setting.Set sms credential'));
            return false;
        }
        if ($active_gateway->add_plus) {
            $receiver_number = '+' . $receiver_number;
        }
        
        $request_data = [
            $active_gateway->send_to_parameter_name => $receiver_number,
            $active_gateway->message_to_parameter_name => $message,
        ];

        foreach ($active_gateway->params as $param) {
            $request_data[$param->key] = $param->value;
        }
        $params = [];
        $user_name = array_key_exists('username', $request_data);
        $password = array_key_exists('password', $request_data);

        if ($user_name && $password && $active_gateway->set_auth == "header") {
            $params['auth'] = [
                $request_data['username'],
                $request_data['password'],
            ];
            unset($request_data['username']);
            unset($request_data['password']);
        }

        $params['form_params'] = $request_data;

        $client = new \GuzzleHttp\Client();
        $method = strtolower($active_gateway->request_method);

        if ($method == 'get') {
            $response = $client->$method($active_gateway->gateway_url . '?' . http_build_query($request_data));
        } else {
            $response = $client->$method($active_gateway->gateway_url, $params);
        }

        return $response;
    }

}
