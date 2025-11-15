<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Course;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;


class PaymentController extends Controller
{

    public function setCommission()
    {
        try {
            $courses = Course::whereNotNull('special_commission')->with('user', 'enrolls')->get();
            $allcourses = Course::select('id', 'title')->latest()->get();
            $commission = Settings('commission');
            $instructors = User::whereNotNull('special_commission')->whereIn('role_id', [2, 5])->latest()->get();
            $instructor_commission = 100 - $commission;
            $users = User::whereIn('role_id', [2, 5])->latest()->get();
            return view('payment::commission', compact('users', 'allcourses', 'courses', 'commission', 'users', 'instructor_commission', 'instructors'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function courseCommissionDelete($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $course = Course::find($id);
            $course->special_commission = null;
            $course->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back()->with(['course' => 'course', 'course_id' => $id]);


        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function courseCommission(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'course_commission' => 'required|numeric|min:0|max:100',
            'course' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $course = Course::find($request->course);
            $course->special_commission = $request->course_commission;
            $course->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back()->with(['course' => 'course', 'course_id' => $request->course, 'amount' => $request->course_commission]);


        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }

    }

    public function saveFlat(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'commission' => 'required|numeric|min:0|max:100',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            UpdateGeneralSetting('commission', $request->commission);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }

    }

    public function instructor_commission(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'special_commission' => 'required|numeric|min:0|max:100',
            'user_id' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {

            $user = User::where('id', $request->user_id)->first();
            $user->special_commission = $request->special_commission;
            $user->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back()->with(['instructor' => 'instructor', 'user_id' => $request->user_id, 'amount' => $request->special_commission]);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function setPayout()
    {
        $user = Auth::user();
        $payment_methods = PaymentMethod::where('active_status', 1)->where('module_status', 1)
            ->where('method', '!=', 'Offline Payment')->where('method', '!=', 'Wallet')->get();
        return view('payment::set_payout', compact('payment_methods', 'user'));
    }

    public function savePayout(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        if ($request->payout == "Bank Payment") {
            $rules = [
                'bank_name' => 'required',
                'branch_name' => 'required',
                'bank_account_number' => 'required',
                'account_holder_name' => 'required',
                'bank_type' => 'required',
            ];

            $this->validate($request, $rules, validationMessage($rules));

        } elseif ($request->payout == "Bkash") {
            $rules = [
                'payout_number' => 'required',
            ];

            $this->validate($request, $rules, validationMessage($rules));

        } else {
            $rules = ['payout_email' => 'required|email'];
            $this->validate($request, $rules, validationMessage($rules));

        }


        $user = User::find(auth()->id());
        $user->payout = $request->payout;
        if ($request->payout == "Bank Payment") {
            $user->bank_name = $request->bank_name;
            $user->branch_name = $request->branch_name;
            $user->bank_account_number = $request->bank_account_number;
            $user->account_holder_name = $request->account_holder_name;
            $user->bank_type = $request->bank_type;
            $user->payout_icon = '';
            $user->payout_email = '';
            if (isModuleActive('Bkash')) {
                $user->bkash_number = '';
            }
        } elseif ($request->payout == "Bkash") {
            $user->bank_name = '';
            $user->branch_name = '';
            $user->bank_account_number = '';
            $user->account_holder_name = '';
            $user->bank_type = '';
            if (isModuleActive('Bkash')) {
                $user->bkash_number = $request->payout_number;
            }
            $user->payout_icon = $request->payout_icon;
            $user->payout_email = '';
        } else {
            $user->bank_name = '';
            $user->branch_name = '';
            $user->bank_account_number = '';
            $user->account_holder_name = '';
            $user->bank_type = '';
            if (isModuleActive('Bkash')) {
                $user->bkash_number = '';
            }
            $user->payout_icon = $request->payout_icon;
            $user->payout_email = $request->payout_email;
        }

        $user->save();

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->route('admin.instructor.payout');
    }
}
