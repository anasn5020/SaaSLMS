<?php

namespace Modules\Newsletter\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AcelleController extends Controller
{
    public $connected, $getResponse;

    public function getAcelleApiResponse()
    {
        try {
            $url = saasEnv('ACELLE_API_URL') . '/login-token';

            $ch = curl_init($url);


            $data = [];

            /* pass encoded JSON string to the POST fields */
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            /* set the content type json */
            $headers = [];
            $headers[] = 'Content-Type:application/json';
            $token = saasEnv('ACELLE_API_TOKEN');
            $headers[] = "Authorization: Bearer " . $token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            /* set return type json */
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_setopt($ch, CURLOPT_TIMEOUT, 3);

            /* execute request */
            $result = curl_exec($ch);

            /* close cURL resource */
            curl_close($ch);


            $response = json_decode($result, true);


            if (isset($response['token'])) {
                $this->connected = true;
            } else {
                $this->connected = false;
            }
            return $this->connected;
        } catch (\Exception $exception) {
            $this->connected = false;
        }
    }

    public function __construct()
    {
        $this->getAcelleApiResponse();
    }

    public function setting()
    {

        $connected = $this->connected;
        $lists = $this->getAcelleList();
        // return $lists;
        return view('newsletter::acelle.setting', compact('connected', 'lists'));
    }

    public function curlGetRequest($url_peram)
    {

        $url = saasEnv('ACELLE_API_URL') . $url_peram;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $token = saasEnv('ACELLE_API_TOKEN');
        $headers = array(
            "Accept: application/json",
            "Authorization: Bearer " . $token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);

        $response = json_decode($resp, true);
        curl_close($curl);
        return $response;
    }

    public function curlPostRequest($url_peram)
    {

        $url = saasEnv('ACELLE_API_URL') . $url_peram;


        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $token = saasEnv('ACELLE_API_TOKEN');
        $headers = array(
            "Accept: application/json",
            "Authorization: Bearer " . $token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = '{}';

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);

        $response = json_decode($resp, true);

        curl_close($curl);

        return $response;
    }

    public function getAcelleList()
    {
        $lists = [];
        if ($this->connected) {
            $response = $this->curlGetRequest('/lists');
            foreach ($response as $key => $uid_list) {
                if (isset($uid_list['uid'])) {
                    $uid_details = $this->curlGetRequest('/lists/' . $uid_list['uid']);
                    if ($uid_details) {
                        $lists[$uid_list['id']]['id'] = $uid_list['id'];
                        $lists[$uid_list['id']]['uid'] = $uid_list['uid'];
                        $lists[$uid_list['id']]['name'] = $uid_list['name'];
                        $lists[$uid_list['id']]['subscriber_count'] = $uid_details['statistics']['subscriber_count'];
                    }
                }

            }
        }

        return $lists;
    }

    public function settingStore(Request $request)
    {

        $request->validate([
            'acelle_url' => 'required',
            'acelle_api' => 'required',
        ]);

        try {
            $key1 = 'ACELLE_API_URL';
            $key2 = 'ACELLE_API_TOKEN';
            $key3 = 'ACELLE_STATUS';

            $value1 = trim($request->acelle_url);
            $value2 = trim($request->acelle_api);
            $this->getAcelleApiResponse();
            $value3 = $this->connected == true ? 'true' : 'false';


            SaasEnvSetting(SaasDomain(), $key1, $value1);
            SaasEnvSetting(SaasDomain(), $key2, $value2);
            SaasEnvSetting(SaasDomain(), $key3, $value3);


            $this->getAcelleApiResponse();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.error'));
            return redirect()->back();
        }
    }


}
