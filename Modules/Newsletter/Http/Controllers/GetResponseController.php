<?php

namespace Modules\Newsletter\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use GetResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class GetResponseController extends Controller
{

    public $connected, $getResponse;


    public function getResponseApi($api)
    {
        try {
            $this->getResponse = new GetResponse($api);
            $status = $this->getResponse->ping();
            if (isset($status->accountId)) {
                $this->connected = true;
            } else {
                $this->connected = false;
            }
        } catch (\Exception $exception) {
            $this->connected = false;
        }
    }

    public function __construct()
    {
        $this->getResponseApi(saasEnv('GET_RESPONSE_API'));
    }


    public function setting()
    {

        $connected = $this->connected;
        $lists = $this->getResponseLists();
        return view('newsletter::getresponse.setting', compact('connected', 'lists'));
    }

    public function settingStore(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'getresponse_api' => 'required',
        ]);

        try {
            $key1 = 'GET_RESPONSE_API';
            $key2 = 'GET_RESPONSE_STATUS';

            $value1 = trim($request->getresponse_api);
            $this->getResponseApi($value1);
            $value2 = $this->connected == true ? 'true' : 'false';

            SaasEnvSetting(SaasDomain(),$key1,$value1);
            SaasEnvSetting(SaasDomain(),$key2,$value2);
            $this->getResponseApi($request->getresponse_api);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.error'));
            return redirect()->back();
        }
    }

    public function getResponseLists()
    {
        $lists = [];
        if ($this->connected) {
            $lists = $this->getResponse->getCampaigns();
        }
        return $lists;
    }
}
