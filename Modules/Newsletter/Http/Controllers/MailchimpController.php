<?php

namespace Modules\Newsletter\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use DrewM\MailChimp\MailChimp;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MailchimpController extends Controller
{
    public $connected, $mailChimp;

    public function mailchimp($api)
    {
        try {
            $this->mailChimp = new MailChimp($api);

            if (isset($this->mailChimp->get('ping')['health_status'])) {
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
        $this->mailchimp(saasEnv('MailChimp_API') ?? '-us1');
    }

    public function setting()
    {
        $connected = $this->connected;
        $lists = $this->mailchimpLists();
        return view('newsletter::mailchimp.setting', compact('connected', 'lists'));
    }

    public function settingStore(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $request->validate([
            'mailchimp_api' => 'required',
        ]);

        try {
            $key1 = 'MailChimp_API';
            $key2 = 'MailChimp_Status';

            $value1 = trim($request->mailchimp_api);
            $this->mailchimp($value1);
            $value2 = $this->connected==true ? 'true' : 'false';

           SaasEnvSetting(SaasDomain(),$key1,$value1);
            SaasEnvSetting(SaasDomain(),$key2,$value2);

        $this->mailchimp($request->mailchimp_api);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();

        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.error'));
            return redirect()->back();
        }
    }


    public function mailchimpLists()
    {
        $lists = [];
        if ($this->connected) {
            $total = $this->mailChimp->get('lists');
            if ($total) {
                $lists = $total['lists'];
            }
        }
        return $lists;
    }
}
