<?php

namespace Modules\Newsletter\Http\Controllers;


use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;

class NewsletterController extends Controller
{
    public $mailchimp, $getResponses;

    public function __construct()
    {
        $this->mailchimp = new MailchimpController();
        $this->getResponses = new GetResponseController();
        $this->acelle = new AcelleController();
    }

    public function setting()
    {
        $setting = NewsletterSetting::getData();
        $lists = $this->mailchimp->mailchimpLists();
        $responsive_lists = $this->getResponses->getResponseLists();
        $acelle_lists = $this->acelle->getAcelleList();
        // return $acelle_lists;
        return view('newsletter::setting', compact('lists', 'setting', 'responsive_lists','acelle_lists'));
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        if ($request->home_service == "Mailchimp") {
            $request->validate([
                'home_list' => 'required',
            ]);
        }
        if ($request->home_service == "GetResponse") {
            $request->validate([
                'home_get_response_list' => 'required',
            ]);
        }
        if ($request->home_service == "Acelle") {
            $request->validate([
                'home_acelle_list' => 'required',
            ]);
        }


        if ($request->student_service == "Mailchimp") {
            $request->validate([
                'student_list' => 'required',
            ]);
        }
        if ($request->student_service == "GetResponse") {
            $request->validate([
                'student_get_response_list' => 'required',
            ]);
        }
        if ($request->student_service == "Acelle") {
            $request->validate([
                'student_acelle_list' => 'required',
            ]);
        }

        if ($request->instructor_service == "Mailchimp") {
            $request->validate([
                'instructor_list' => 'required',
            ]);
        }
        if ($request->instructor_service == "GetResponse") {
            $request->validate([
                'instructor_get_response_list' => 'required',
            ]);
        }
        if ($request->instructor_service == "Acelle") {
            $request->validate([
                'instructor_acelle_list' => 'required',
            ]);
        }

        try {

            $setting = NewsletterSetting::first();
            $setting->home_service = $request->home_service;
            $setting->student_service = $request->student_service;
            $setting->instructor_service = $request->instructor_service;


            if ($request->home_service == "Mailchimp") {
                $setting->home_list_id = $request->home_list;
            }
            if ($request->home_service == "GetResponse") {
                $setting->home_list_id = $request->home_get_response_list;
            }
            if ($request->home_service == "Acelle") {
                $setting->home_list_id = $request->home_acelle_list;
            }

            if ($request->student_service == "Mailchimp") {
                $setting->student_list_id = $request->student_list;
            }
            if ($request->student_service == "GetResponse") {
                $setting->student_list_id = $request->student_get_response_list;
            }
            if ($request->student_service == "Acelle") {
                $setting->student_list_id = $request->student_acelle_list;
            }

            if ($request->instructor_service == "Mailchimp") {
                $setting->instructor_list_id = $request->instructor_list;

            }
            if ($request->instructor_service == "GetResponse") {
                $setting->instructor_list_id = $request->instructor_get_response_list;
            }
            if ($request->instructor_service == "Acelle") {
                $setting->instructor_list_id = $request->instructor_acelle_list;
            }

            if ($request->home_status) {
                $setting->home_status = 1;
            } else {
                $setting->home_status = 0;
            }
            if ($request->student_status) {
                $setting->student_status = 1;
            } else {
                $setting->student_status = 0;
            }
            if ($request->instructor_status) {
                $setting->instructor_status = 1;
            } else {
                $setting->instructor_status = 0;
            }
            $setting->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function subscriber()
    {
        $subscribers = Subscription::latest()->get();

        return view('frontendmanage::subscriber', compact('subscribers'));
    }

    public function subscriberDelete($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $data = Subscription::find($id);
            $data->delete();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
