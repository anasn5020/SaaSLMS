<?php

namespace Modules\Coupons\Http\Controllers;

use App\Exports\ExportSampleCommonCoupon;
use App\Http\Controllers\Controller;
use App\Imports\CommonCouponImport;
use App\InviteSetting;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Coupons\Entities\Coupon;
use Modules\Coupons\Entities\UserWiseCoupon;
use Modules\Coupons\Entities\UserWiseCouponSetting;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\RolePermission\Entities\Role;
use Validator;

class CouponsController extends Controller
{

    public function invitebyCode()
    {
        $user_wise_coupons = UserWiseCoupon::all();
        $categories = Category::orderBy('position_order', 'asc')->get();
        if (Auth::user()->role_id == 1) {
            $roles = Role::all();
        } elseif (Auth::user()->role_id == 2) {
            $roles = Role::where('id', '!=', 1)->get();
        } else {
            $roles = Role::where('id', 3)->get();
        }

        $inviteSettings = UserWiseCouponSetting::all();
        return view('coupons::invitebyCode', compact('inviteSettings', 'roles', 'user_wise_coupons', 'categories'));
    }

    public function inviteSettings()
    {

        if (Auth::user()->role_id == 1) {
            $roles = Role::all();
        } elseif (Auth::user()->role_id == 2) {
            $roles = Role::where('id', '!=', 1)->get();
        } else {
            $roles = Role::where('id', 3)->get();
        }

        $inviteSettings = UserWiseCouponSetting::get();
        return view('coupons::inviteSettings', compact('inviteSettings', 'roles'));
    }

    public function inviteSettingEdit($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        if (Auth::user()->role_id == 1) {
            $roles = Role::all();
        } elseif (Auth::user()->role_id == 2) {
            $roles = Role::where('id', '!=', 1)->get();
        } else {
            $roles = Role::where('id', 3)->get();
        }

        $edit = UserWiseCouponSetting::find($id);
        $inviteSettings = UserWiseCouponSetting::all();
        return view('coupons::inviteSettings', compact('inviteSettings', 'roles', 'edit'));
    }

    public function inviteSettingDelete($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $delete = UserWiseCouponSetting::find($id)->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function inviteSettingStore(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'max_limit' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));
        try {
            $invite_setting = UserWiseCouponSetting::where('role_id', 3)->first();
            if ($invite_setting == null) {
                $invite_setting = new UserWiseCouponSetting();
            }
            $invite_setting->role_id = 3;
            $invite_setting->type = (int)$request->type;
            $invite_setting->status = (int)$request->status;
            $invite_setting->amount = (int)$request->amount;
            $invite_setting->max_limit = (int)$request->max_limit;
            $invite_setting->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('coupons.inviteSettings');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function coupon_delete($id)
    {
        if (demoCheckById($id,[1,2])) {
            return redirect()->back();
        }
        try {
            $deleted = Coupon::find($id)->delete();
            if ($deleted) {
                $coupons = Coupon::latest()->get();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);

        }
    }


    public function coupon_single(Request $request)
    {
        try {
            $categories = Category::orderBy('position_order', 'asc')->get();
            $query = Coupon::with('totalUsed','course','getCategory','getSubCategory')->where('category', 2);
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }

            $coupons = $query->latest()->get();
            $edit = Coupon::find($request->id);
            if (!empty($edit)) {
                $subcategories = Category::where('parent_id', $edit->category_id)->orderBy('position_order', 'asc')->get();
                $edit->subcategories = $subcategories;
                $courseQuery = Course::where('category_id', $edit->category_id);
                if (!empty($edit->subcategory_id)) {
                    $courseQuery->where('subcategory_id', $edit->subcategory_id);
                }

                if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                    $courseQuery->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                }

                $courses = $courseQuery->get();
                $edit->courses = $courses;

            }
            return view('coupons::single_coupons', compact('edit', 'coupons', 'categories'));
        } catch (\Exception $e) {
            dd($e);
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));

            return redirect()->back();
        }
    }


    public function coupon_personalized(Request $request)
    {
        try {

            $query = Coupon::with('totalUsed')->where('category', 3);
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }
            $coupons = $query->latest()->get();
            $edit = Coupon::find($request->id);

            $query2 = User::where('role_id', 3);
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query2->where('organization_id', Auth::id());
                $query2->orWhere('id', Auth::id());
            }
            $users = $query2->get();

            return view('coupons::personalized_coupons', compact('edit', 'coupons', 'users'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }


    public function index()
    {
        try {
            $query = Coupon::with('totalUsed');

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }

            $coupons = $query->latest()->get();
            return view('coupons::coupons', compact('coupons',));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);

        }
    }

    public function coupon_common(Request $request)
    {
        try {
            $query = Coupon::with('totalUsed')->where('category', 1);
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }
            $coupons = $query->latest()->get();
            $edit = Coupon::find($request->id);

            return view('coupons::common_coupons', compact('coupons','edit'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);

        }
    }



    public function coupon_common_import()
    {
        try {
            return view('coupons::common_coupons_import');
        } catch (\Exception $e) {
            Toastr::error(trans("lang.Operation Failed"), trans('common.Error'));
            return redirect()->back();
        }
    }
    public function coupon_common_import_submit(Request $request)
    {
        $rules = [
            'excel_file' => 'required',
        ];


        $this->validate($request, $rules, validationMessage($rules));

        if ($request->hasFile('excel_file')) {
            $extension = File::extension($request->excel_file->getClientOriginalName());
            if ($extension != "xlsx" && $extension != "xls") {
                Toastr::error(trans('frontend.Excel File is Required'), trans('common.Failed'));
                return redirect()->back();
            }
        }

        try {
            Excel::import(new CommonCouponImport(), $request->excel_file);


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return redirect()->route('coupons.common.import');

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

        public function coupon_common_import_sample()
    {
        return Excel::download(new ExportSampleCommonCoupon(), 'sample-common-coupon.xlsx');

    }

    public function saveCoupon(Request $request)
    {
         if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required|max:255',
            'code' => ['required', Rule::unique('coupons', 'code')->when(isModuleActive('LmsSaas'), function ($q) {
                return $q->where('lms_id', app('institute')->id);
            })],
            'category' => 'required',
            'category_id' => 'required_if:category,2',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];


        $this->validate($request, $rules, validationMessage($rules));


        try {
            $coupon = new Coupon();
            $coupon->user_id = Auth::id();
            if ($request->category) {
                $coupon->category = $request->category;
            }
            if ($request->category_id) {
                $coupon->category_id = $request->category_id;
            }
            if ($request->subcategory_id) {
                $coupon->subcategory_id = $request->subcategory_id;
            }
            if ($request->course_id) {
                $coupon->course_id = $request->course_id;
            }
            if ($request->coupon_user_id) {
                $coupon->coupon_user_id = $request->coupon_user_id;
            }
            $coupon->title = $request->title;
            $coupon->code = $request->code;
            $coupon->type = (int)$request->get('type');
            $coupon->value = $request->value;
            $coupon->limit = (int)$request->get('limit', 0);

            $coupon->min_purchase = $request->min_purchase;
            $coupon->max_discount = $request->max_discount;
            $coupon->start_date = date('Y-m-d', strtotime($request->start_date));
            $coupon->end_date = date('Y-m-d', strtotime($request->end_date));

            $coupon->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();

        } catch (\Exception $e) {
            Toastr::error(trans("lang.Operation Failed"), trans('common.Error'));

            return response()->json(['error' => trans("lang.Operation Failed")]);

        }
    }


    public function editCoupon($id)
    {
        try {
            $edit = Coupon::find($id);

            $query = Coupon::with('totalUsed');

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }

            $coupons = $query->latest()->get();
            return view('coupons::coupons', compact('coupons', 'edit'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);

        }
    }


    public function updateCoupon(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'code' => ['required', Rule::unique('coupons', 'code')->ignore($request->id)->when(isModuleActive('LmsSaas'), function ($q) {
                return $q->where('lms_id', app('institute')->id);
            })],
            'value' => 'required',
            'min_purchase' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {


            $coupon = Coupon::find($request->id);
            $coupon->user_id = Auth::id();
            $coupon->title = $request->title;
            $coupon->limit = $request->limit;

            if ($request->category) {
                $coupon->category = $request->category;
            }
            if ($request->category_id) {
                $coupon->category_id = $request->category_id;
            }
            if ($request->subcategory_id) {
                $coupon->subcategory_id = $request->subcategory_id;
            }
            if ($request->course_id) {
                $coupon->course_id = $request->course_id;
            }
            if ($request->coupon_user_id) {
                $coupon->coupon_user_id = $request->coupon_user_id;
            }

            $coupon->code = $request->code;
            $coupon->type = (int)$request->get('type');
            $coupon->value = $request->value;
            $coupon->min_purchase = $request->min_purchase;
            $coupon->max_discount = $request->max_discount;
            $coupon->start_date = date('Y-m-d', strtotime($request->start_date));
            $coupon->end_date = date('Y-m-d', strtotime($request->end_date));
            $coupon->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            if ($coupon->category == 3) {
                return redirect()->route('coupons.personalized');
            }
            if ($coupon->category == 2) {
                return redirect()->route('coupons.single');
            }
            if ($coupon->category == 1) {
                return redirect()->route('coupons.common');
            }
            return redirect()->route('coupons.manage');


        } catch (\Exception $e) {
            return response()->json(['error' => 'Operation Failed']);

        }
    }
}
