<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\WebsiteController;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Certificate\Entities\Certificate;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\Certificate\Http\Controllers\CertificateController;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseCanceled;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Payment\Entities\InstructorPayout;
use Modules\Payment\Entities\InstructorTotalPayout;
use Modules\Payment\Entities\Withdraw;
use Modules\StudentSetting\Entities\Institute;
use Modules\Subscription\Entities\SubscriptionCheckout;
use Modules\Subscription\Entities\SubscriptionCourse;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    use SendNotification;

    public function enrollLogs(Request $request)
    {
        $courseId = $request->get('course', '');
        $start = !empty($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : '';
        $end = !empty($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : '';

        try {
            $enrolls = [];
            $course_query = Course::where('status', 1)
                ->whereIn('type', [1,2,3]);

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $course_query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }

            $courses = $course_query->select('id', 'title', 'type')->get();

            $query = User::where('role_id', 3);
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->where('organization_id', Auth::id());
                $query->orWhere('id', Auth::id());
            }
            $students = $query->get();
            return view('backend.student.enroll_student', compact('courseId', 'start', 'end', 'enrolls', 'courses', 'students'));

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function cancelLogs(Request $request)
    {
        $courseId = $request->get('course', '');
        $start = !empty($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : '';
        $end = !empty($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : '';

        try {
            $enrolls = [];
            $course_query = Course::where('status', 1)->whereIn('type', [1,2,3]);

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $course_query->whereHas('user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }

            $courses = $course_query->select('id', 'title', 'type')->get();

            $query = User::where('role_id', 3);
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->where('organization_id', Auth::id());
                $query->orWhere('id', Auth::id());
            }
            $students = $query->get();
            return view('backend.student.cancel_student', compact('courseId', 'start', 'end', 'enrolls', 'courses', 'students'));

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function enrollFilter(Request $request)
    {

        try {
            $courseId = $request->get('course', '');
            $start = !empty($request->start_date) ? date('Y-m-d', strtotime($request->start_date)) : '';
            $end = !empty($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : '';


            $courses = Course::query()->whereIn('type', [1,2,3])->get();
            $query = User::where('role_id', 3);
            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->where('organization_id', Auth::id());
            }
            $students = $query->get();
            return view('backend.student.enroll_student', compact('courseId', 'start', 'end', 'courses', 'students'));


        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function reveuneList()
    {
        try {
            $courses = Course::with('enrolls', 'user')->withCount('enrolls')->get();
            return view('payment::admin_revenue', compact('courses'));
        } catch (Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);


        }
    }

    public function reveuneListInstructor(Request $request)
    {
        try {
            $search_instructor = $request->get('instructor', '');
            $search_month = $request->get('month', '');
            $search_year = empty($request->year) ? date('Y') : $request->year;
            $query = CourseEnrolled::with('course', 'user', 'course.user');

            if (!empty($search_month)) {
                $from = date($search_year . '-' . $search_month . '-1');
                $to = date($search_year . '-' . $search_month . '-31');
                $query->whereBetween('created_at', [$from, $to]);
            }

            if (Auth::user()->role_id == 2) {
                $query->whereHas('course', function ($q) {
                    $q->where('user_id', Auth::user()->id);
                });
            }
            if (!empty($request->instructor)) {
                $query->whereHas('course', function ($q) {
                    $q->where('user_id', \request('instructor'));
                });
            }

            $enrolls = $query->whereHas('course.user', function ($query) {
                $query->where('id', '!=', 1);
            })->latest()->get();


            $query2 = DB::table('subscription_courses')
                ->select('subscription_courses.*')
                ->selectRaw("SUM(revenue) as total_price");
            if (Auth::user()->role_id == 2) {
                $query2->where('user_id', '=', Auth::user()->id);
            }


            if (isModuleActive('Subscription')) {
                $subscriptionsData = $query2->groupBy('checkout_id')
                    ->latest()->get();
                $subscriptions = [];
                foreach ($subscriptionsData as $key => $data) {
                    $subscriptions[$key]['checkout_id'] = $data->checkout_id;
                    $subscriptions[$key]['date'] = $data->date;
                    $subscriptions[$key]['price'] = $data->total_price;
                    $user = User::where('id', $data->instructor_id)->first();
                    $subscriptions[$key]['instructor'] = $user->name ?? '';

                    $plan = SubscriptionCheckout::where('id', $data->checkout_id)->first();

                    $subscriptions[$key]['plan'] = $plan->plan->title ?? '';
                }


            } else {
                $subscriptions = [];
            }
            $instructors = User::where('role_id', 2)->get();
            return view('payment::instructor_revenue_report', compact('search_instructor', 'search_month', 'search_year', 'instructors', 'enrolls', 'subscriptions'));
        } catch
        (Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }

    }

    public function sortByDiscount(Request $request)
    {

        $rules = [
            'discount' => 'required',
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $id = $request->id;
            $val = $request->discount;
            $start = date('Y-m-d', strtotime($request->start_date));
            $end = date('Y-m-d', strtotime($request->end_date));
            $method = $request->methods;
            if ((isset($request->end_date)) && (isset($request->start_date))) {

                if ($val == 10) {

                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '>', 0)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->latest()->with('user')->get();
                } else {

                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '=', 0)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->latest()->with('user')->get();

                }
            } elseif (is_null($request->start_date) && is_null($request->end_date)) {

                if ($val == 10) {

                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '>', 0)->with('user', 'course')->latest()->get();
                } else {

                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '=', 0)->with('user', 'course')->latest()->get();

                }
            } elseif (isset($request->start_date) && is_null($request->end_date)) {


                if ($val == 10) {

                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '>', 0)->with('user', 'course')->whereDate('created_at', '>=', $start)->latest()->get();
                } else {

                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '=', 0)->with('user', 'course')->whereDate('created_at', '>=', $start)->latest()->get();

                }

            } elseif (isset($request->end_date) && is_null($start)) {

                if ($val == 10) {

                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '>', 0)->with('user', 'course')->whereDate('created_at', '<=', $end)->latest()->get();
                } else {

                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '=', 0)->with('user', 'course')->whereDate('created_at', '<=', $end)->latest()->get();

                }
            }
            $course_id = $request->id;
            return view('payment::enroll_log', compact('logs', 'course_id'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }


    public function courseEnrolls($id)
    {

        try {
            $logs = CourseEnrolled::where('course_id', $id)->with('user', 'course')->latest()->get();
            $course_id = $id;
            return view('payment::enroll_log', compact('logs', 'course_id'));
        } catch (Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);


        }
    }

    public function instructorPayout(Request $request)
    {
        $instructors = User::where('role_id', 2)->get(['id', 'name']);

        $next_pay = InstructorPayout::where('instructor_id', Auth::user()->id)->whereStatus('0')->sum('reveune');
        if (isModuleActive('Subscription')) {
            $subscriptionPay = SubscriptionCourse::where('instructor_id', Auth::user()->id)->whereStatus('0')->sum('revenue');
            $next_pay = $next_pay + $subscriptionPay;
        }


        $user = Auth::user();

        $instructorTotal = InstructorTotalPayout::where('instructor_id', $user->id)->first();
        if (!$instructorTotal) {
            $instructorTotal = new InstructorTotalPayout();
            $instructorTotal->instructor_id = $user->id;
        }
        $instructorTotal->amount = $instructorTotal->amount + $next_pay;
        $instructorTotal->save();

        $remaining = $instructorTotal->amount;

        InstructorPayout::where('instructor_id', $user->id)->whereStatus('0')->update(['status' => 1]);
        if (isModuleActive('Subscription')) {
            SubscriptionCourse::where('instructor_id', $user->id)->whereStatus('0')->update(['status' => 1]);
        }

        return view('payment::instructor_payout', compact('remaining', 'instructors'));
    }

    public function instructorRequestPayout(Request $request)
    {
        try {
            $minAmount = (int)Settings('minimum_payout_amount');
            $user = Auth::user();
            $totalPayout = InstructorTotalPayout::where('instructor_id', $user->id)->first();
            $maxAmount = $totalPayout->amount;
            $amount = $request->amount;

            if ($maxAmount < $amount) {
                Toastr::error(trans('payment.Max Limit is').' ' . getPriceFormat($maxAmount), trans('common.Error'));
                return redirect()->back();
            }
                if ($minAmount!=0 && $minAmount > $amount) {
                Toastr::error(trans('payment.Minimum Amount is').' ' . getPriceFormat($minAmount), trans('common.Error'));
                return redirect()->back();
            }

            $withdraw = new Withdraw();
            $withdraw->instructor_id = Auth::user()->id;
            $withdraw->amount = $amount;
            $withdraw->issueDate = Carbon::now();
            $withdraw->method = Auth::user()->payout;
            $withdraw->save();
            $totalPayout->amount = $totalPayout->amount - $amount;
            $totalPayout->save();


            if (Auth::user()->role_id != 1) {
                $admins = User::where('role_id', 1)->get();
                foreach ($admins as $user) {
                    $this->sendNotification('PayoutRequest',$user,[
                        'admin' => $user->name,
                        'amount' => $amount,
                        'instructor' => Auth::user()->name,
                    ]);
                }
            }

            Toastr::success(trans('lang.Payment request has been successfully submitted'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function instructorCompletePayout(Request $request)
    {
        try {
            DB::beginTransaction();
            $withdraw = Withdraw::whereId($request->withdraw_id)->whereInstructorId($request->instructor_id)->first();
            $instractor = User::find($request->instructor_id);
            $withdraw->status = 1;
            $withdraw->save();
            $instractor->balance += $withdraw->amount;
            $instractor->save();
            DB::commit();
            Toastr::success(trans('lang.Payment request has been Approved'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function enrollDelete(Request $request)
    {

        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->id;

        if (demoCheckById($id,[1,2,3,4,5,6,7,8,9,10])) {
            return redirect()->back();
        }


        if (isset($request->cancel)) {
            $deleteEnroll = $enroll = CourseCanceled::with('course', 'user')->findOrFail($id);
        } else {
            $deleteEnroll = $enroll = CourseEnrolled::with('course', 'user')->findOrFail($id);

        }

        $student = $enroll->user;

        if($student) {
            if (isset($request->refund)) {
                $student->balance = $student->balance + $enroll->purchase_price;
                $student->save();
                $act = 'Enroll_Refund';
                $status = 1;
            } else {
                $act = 'Enroll_Rejected';
                $status = 0;
            }
            $reason = $request->reason;
            if (!isset($request->cancel)) {
                $this->courseCanceled($enroll->user_id, $enroll->course_id, $enroll->purchase_price, $status, $reason);
                $deleteEnroll->delete();
            } else {
                $deleteEnroll->refund = $status;
                $deleteEnroll->save();
            }

            $this->sendNotification($act, $enroll->user, [
                'course' => $enroll->course->getTranslation('title', $enroll->user->language_code ?? config('app.fallback_locale')),
                'time' => now(),
                'reason' => $reason
            ], [
                'actionText' => trans('common.View'),
                'actionUrl' => courseDetailsUrl(@$enroll->course->id, @$enroll->course->type, @$enroll->course->slug)
            ]);
            $this->sendNotification($act, $enroll->course->user, [
                'course' => $enroll->course->getTranslation('title', $enroll->course->user->language_code ?? config('app.fallback_locale')),
                'time' => now(),
                'reason' => $reason
            ], [
                'actionText' => trans('common.View'),
                'actionUrl' => courseDetailsUrl(@$enroll->course->id, @$enroll->course->type, @$enroll->course->slug)
            ]);
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }
    public function enrollDeleteBulk(Request $request)
    {
        $request->validate([
            'ids' => 'required',
        ]);

        $ids = explode(',', $request->ids);
        foreach ($ids as $id){

            if (demoCheckById($id,[1,2,3,4,5,6,7,8,9,10])) {
                return redirect()->back();
            }

            if (isset($request->cancel)) {
                $deleteEnroll = $enroll = CourseCanceled::with('course', 'user')->findOrFail($id);
            } else {
                $deleteEnroll = $enroll = CourseEnrolled::with('course', 'user')->findOrFail($id);

            }

            $student = $enroll->user;

            if($student && $student->email) {
                if (isset($request->refund)) {
                    $student->balance = $student->balance + $enroll->purchase_price;
                    $student->save();
                    $act = 'Enroll_Refund';
                    $status = 1;
                } else {
                    $act = 'Enroll_Rejected';
                    $status = 0;
                }
                $reason = $request->reason;
                if (!isset($request->cancel)) {
                    $this->courseCanceled($enroll->user_id, $enroll->course_id, $enroll->purchase_price, $status, $reason);
                } else {
                    $deleteEnroll->refund = $status;
                    $deleteEnroll->save();
                }

                $this->sendNotification($act, $enroll->user, [
                    'course' => $enroll->course->getTranslation('title', $enroll->user->language_code ?? config('app.fallback_locale')),
                    'time' => now(),
                    'reason' => $reason
                ], [
                    'actionText' => trans('common.View'),
                    'actionUrl' => courseDetailsUrl(@$enroll->course->id, @$enroll->course->type, @$enroll->course->slug)
                ]);
                $this->sendNotification($act, $enroll->course->user, [
                    'course' => $enroll->course->getTranslation('title', $enroll->course->user->language_code ?? config('app.fallback_locale')),
                    'time' => now(),
                    'reason' => $reason
                ], [
                    'actionText' => trans('common.View'),
                    'actionUrl' => courseDetailsUrl(@$enroll->course->id, @$enroll->course->type, @$enroll->course->slug)
                ]);
            }

            $deleteEnroll->delete();

        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function courseCanceled($user_id, $course_id, $price, $status, $reason)
    {
        $user = Auth::user();
        $cancle = new CourseCanceled();
        $cancle->user_id = $user_id;
        $cancle->course_id = $course_id;
        $cancle->purchase_price = (int)$price;
        $cancle->refund = $status;
        $cancle->cancel_by = $user->id;
        $cancle->reason = $reason ?? '';
        $cancle->approved_date = date('Y-m-d');

        $cancle->save();
    }

    public function getEnrollLogsData(Request $request)
    {
        $user = Auth::user();
        $query = CourseEnrolled::select('course_enrolleds.*')->with('user:id,name,image,email', 'course:id,title', 'course.enrolls:id', 'course.certificate_records');


        if ($user->role_id == 2) {
            $query->whereHas('course', function ($query) use ($user) {
                $query->where('user_id', '=', $user->id);
            });

        } else {

            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {

                $query->where(function ($query){
                    $query->whereHas('user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    })->orWhereHas('course.user', function ($q) {
                        $q->where('organization_id', Auth::id());
                        $q->orWhere('id', Auth::id());
                    });
                });
            }
        }


        if (!empty($request->course)) {
            $query->where('course_id', $request->course);
        }
        if (!empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if (!empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        $query->whereHas('user');

//dd($request->all());
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($query) {
                return view('backend.student._td_bulk_checkbox', compact('query'));
            })
            ->addColumn('image', function ($query) {
                $image = $query->user->image;
                $user = $query->user->name;
                return view('backend.partials._small_profile_image', compact('image', 'user'));
            })->editColumn('user.name', function ($query) {
                return $query->user->name;

            })->editColumn('user.email', function ($query) {
                return $query->user->email;

            })
            ->editColumn('course.title', function ($query) {
                return $query->course->title;

            })
            ->editColumn('created_at', function ($query) {
                return showDate(@$query->created_at);

            })->editColumn('purchase_price', function ($query) {
                return getPriceFormat(@$query->purchase_price);

            })
            ->addColumn('action', function ($query) {

                return view('backend.student._td_enroll_log', compact('query'));

            })->rawColumns(['image', 'action'])->make(true);
    }

    public function getCancelLogsData(Request $request)
    {
        $user = Auth::user();
        if ($user->role_id == 2) {
            $query = CourseCanceled::with('user', 'course', 'confirmUser')
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                });
        } else {
            $query = CourseCanceled::with('user', 'course', 'confirmUser');


            if (isModuleActive('Organization') && Auth::user()->isOrganization()) {
                $query->whereHas('course.user', function ($q) {
                    $q->where('organization_id', Auth::id());
                    $q->orWhere('id', Auth::id());
                });
            }
        }

        if ($request->f_course) {
            $query->where('course_id', $request->f_course);
        }
        if ($request->f_user) {
            $query->where('user_id', $request->f_user);
        }
        if ($request->f_type) {
            $query->where('refund', $request->f_type == 1 ? 1 : 0);
        }

        if ($request->f_status != null) {

            if ($request->f_status == 3) {
                $status = 0;
            } else {
                $status = $request->f_status;
            }
            $query->where('status', $status);
        }

        if ($request->f_date) {
            $query->whereBetween(DB::raw('DATE(created_at)'), formatDateRangeData($request->f_date));
        }


        $query->select('course_canceleds.*');


        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('user_name', function ($query) {
                return $query->user->name;

            })
            ->addColumn('confirm_user', function ($query) {
                return $query->confirmUser->name;

            })
            ->addColumn('user_email', function ($query) {
                return $query->user->email;

            })
            ->addColumn('course', function ($query) {
                return $query->course->title;

            })
            ->editColumn('purchase_price', function ($query) {
                return getPriceFormat(@$query->purchase_price);

            })
            ->editColumn('created_at', function ($query) {
                return showDate(@$query->created_at);

            })
            ->editColumn('approved_date', function ($query) {
                if ($query->approved_date) {
                    return showDate(@$query->approved_date);
                }else{
                    return trans('common.N/A');
                }
                return '';

            })
            ->editColumn('refund', function ($query) {
                return $query->refund == 1 ? 'Refund' : 'Cancel';
            })
            ->addColumn('total_complete', function ($query) {

                return $query->course->userCourseCompletePercentage($query->user_id) . "%";
            })
            ->editColumn('status', function ($query) {

                if ($query->status == 1) {
                    $status = 'Approved';
                } elseif ($query->status == 0) {
                    $status = 'Pending';
                } else {
                    $status = 'Reject';
                }
                return $status;
            })
            ->addColumn('action', function ($query) {
                return view('backend.student._td_cancel_error_log', compact('query'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getPayoutData(Request $request)
    {
        try {
            $query = Withdraw::latest()->with('user');
            if (!empty($request->month)) {
                $query->whereMonth('created_at', '=', $request->month);
            }
            if (!empty($request->year)) {
                $query->whereYear('created_at', '=', $request->year);
            }
            if (!empty($request->instructor)) {
                $query->where('instructor_id', '=', $request->instructor);
            }
            if (Auth::user()->role_id != 1) {
                $query->where('instructor_id', '=', Auth::user()->id);
            }

            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('user.name', function ($query) {
                    return $query->user->name;
                })
                ->editColumn('amount', function ($query) {
                    return getPriceFormat($query->amount,false);
                })
                ->addColumn('requested_date', function ($query) {
                    return showDate(@$query->created_at);
                })
                ->editColumn('method', function ($query) {
                    $withdraw = $query;
                    return view('backend.partials._withdrawMethod', compact('withdraw'));
                })
                ->addColumn('status', function ($query) {
                    if ($query->status == 1) {
                        $status = trans('common.Paid');
                    } else {
                        $status = trans('common.Unpaid');
                    }
                    return $status;
                })
                ->addColumn('action', function ($query) {
                    return view('backend.instructor._td_payout_action', compact('query'));
                })
                ->rawColumns(['method', 'user.image', 'action'])
                ->make(true);

        } catch (Exception $e) {

        }
    }


    public function getUserDate($id)
    {
        $user = User::with('image_media')->find($id);
        $user->dob = getJsDateFormat($user->dob);
        return $user;
    }

    public function removeImageByAjax(Request $request)
    {
        $table = $request->get('table');
        $name = $request->get('name');
        $id = $request->get('id');

        if ($table && $name && $id) {
            DB::table($table)->where('id', $id)->update([
                $name => ''
            ]);
        }
        return true;
    }


    public function generateCertificate(Request $request)
    {
        $enroll = CourseEnrolled::with('course', 'user')->findOrFail($request->id);
        $course = $enroll->course;

        try {
            $certificate = null;
            if (!empty($course->certificate_id)) {
                $certificate = Certificate::find($course->certificate_id);
            }
            if (!$certificate) {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } elseif ($course->type == 2) {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                } elseif ($course->type == 3) {
                    $certificate = Certificate::where('for_class', 1)->first();
                } else {
                    $certificate = null;
                }
            }
            if ($certificate) {
                $websiteController = new WebsiteController();
                $certificate_record = CertificateRecord::where('student_id', $enroll->user_id)->where('course_id', $enroll->course_id)->first();
                if (!$certificate_record) {
                    $certificate_record = new CertificateRecord();
                    $certificate_record->certificate_id = $websiteController->generateUniqueCode();
                    $certificate_record->student_id = $enroll->user_id;
                    $certificate_record->course_id = $enroll->course_id;
                    $certificate_record->created_by = Auth::id();
                    $certificate_record->save();
                }

                request()->certificate_id = $certificate_record->certificate_id;
                request()->course = $course;
                request()->user = $enroll->user;
                $downloadFile = new CertificateController();
                $certificate = $downloadFile->makeCertificate($certificate->id, request())['image'] ?? '';

                if ($certificate){
                    $certificate->toJpeg()->save('public/certificate/' . $certificate_record->id . '.jpg');
                }


            } else {
                Toastr::error(trans('certificate.Certificate Not Found!'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function removeCertificate(Request $request)
    {
        $enroll = CourseEnrolled::with('course', 'user')->findOrFail($request->id);
        CertificateRecord::where('student_id', $enroll->user_id)->where('course_id', $enroll->course_id)->delete();
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function institutionWiseUser(Request $request)
    {
        if ($request->ajax()){
            $user = Auth::user();
            $query = User::where('status', 1);
            if (isModuleActive('LmsSaas')) {
                $query->where('lms_id', app('institute')->id);
            } else {
                $query->where('lms_id', 1);
            }
            if (isModuleActive('UserType')) {
                $query->whereHas('userRoles', function ($q) {
                    $q->where('role_id', 3);
                });
            } else {
                $query->where('role_id', 3);
            }
            if (isModuleActive('Organization') && $user->isOrganization()) {
                $query->where('organization_id', $user->id);
            }
            if ($request->institute) {
                $query->where('institute_id', $request->institute);
            }

            $query->with('studentInstitute');

            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('image', function ($query) {
                    return view('backend.partials._td_image', compact('query'));
                })->editColumn('name', function ($query) {
                    $title = $query->name;
                    $link = $query->username ? route('profileUniqueUrl', $query->username) : '';
                    return view('studentsetting::partials._td_link', compact('query', 'link', 'title'));

                })->editColumn('email', function ($query) {
                    return $query->email;

                })
                ->editColumn('phone', function ($query) {
                    return translatedNumber($query->phone);

                })
                ->addColumn('institute_name', function ($query) {
                    return $query->studentInstitute?->name;

                })
                 ->rawColumns(['image','name'])
                ->make(true);
        }

        $institutes =Institute::where('status', 1)->select('id', 'name')->get();

        return view('backend.report.institution_wise_user',compact('institutes'));
    }
    public function institutionWisePerformance(Request $request)
    {
        if ($request->ajax()) {
           return $this->statisticDatatable($request);
        }
        $institutes =Institute::where('status', 1)->select('id', 'name')->get();
        return view('backend.report.institution_wise_performance',compact('institutes'));

    }

    public function statisticDatatable($request)
    {
        $filters['status'] =1;
        if ($request->institute) {
            $filters['institute_id'] = $request->institute;
        }
        if ($request->user) {
            $filters['user_id'] = $request->user;
        }

        $query = $this->courseStatisticFilterQuery();
        if ($request->type==1) {
            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('required_type', function ($query) {
                    return $query->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open');
                })->editColumn('mode_of_delivery', function ($query) {
                    if ($query->mode_of_delivery == 1) {
                        $title = trans('courses.Online');

                    } elseif ($query->mode_of_delivery == 2) {
                        $title = trans('courses.Distance Learning');
                    } else {
                        if (isModuleActive('Org')) {
                            $title = trans('courses.Offline');
                        } else {
                            $title = trans('courses.Face-to-Face');
                        }
                    }
                    return $title;
                })
                ->addColumn('type', function ($query) {
                    return $query->type == 1 ? trans('courses.Course') : trans('quiz.Quiz');

                })
                ->editColumn('total_enrolled', function ($query) use ($filters) {
                    return translatedNumber($query->totalStatistic($filters)['total_enroll']);
                })->editColumn('title', function ($query) {
                    return $query->title;
                })
                ->addColumn('not_start', function ($query) use ($filters) {
                    return translatedNumber($query->totalStatistic($filters)['not_start']);
                })
                ->addColumn('in_process', function ($query) use ($filters){
                    return translatedNumber($query->totalStatistic($filters)['in_process']);
                })
                ->addColumn('finished', function ($query) use ($filters) {
                    return translatedNumber($query->totalStatistic($filters)['finished']);
                })
                ->addColumn('finished_rate', function ($query) use ($filters) {
                    $finished = $query->totalStatistic($filters)['finished'];
                    $not_start = $query->totalStatistic($filters)['not_start'];
                    $in_process = $query->totalStatistic($filters)['in_process'];
                    $total = $finished+$not_start+$in_process;



                    $percentage = 0;
                    if ($total != 0) {
                        $percentage = ($finished / $total) * 100;
                        if ($percentage > 100) {
                            $percentage = 100;
                        }
                    }
                    return translatedNumber(round($percentage)) . '%';
                })
                ->make(true);
        }elseif($request->type==2){
            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('title', function ($query) {
                    return $query->title;
                })
                ->editColumn('required_type', function ($query) {
                    return $query->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open');
                })->editColumn('mode_of_delivery', function ($query) {
                    if ($query->mode_of_delivery == 1) {
                        $title = trans('courses.Online');

                    } elseif ($query->mode_of_delivery == 2) {
                        $title = trans('courses.Distance Learning');
                    } else {
                        if (isModuleActive('Org')) {
                            $title = trans('courses.Offline');
                        } else {
                            $title = trans('courses.Face-to-Face');
                        }
                    }
                    return $title;
                })
                ->addColumn('type', function ($query) {
                    return $query->type == 1 ? trans('courses.Course') : trans('quiz.Quiz');

                })
                ->editColumn('total_enrolled', function ($query) use ($filters) {
                    return translatedNumber($query->totalQuizStatistic($filters)['total_enroll']);
                })
                ->addColumn('not_start', function ($query) use ($filters) {
                    return translatedNumber($query->totalQuizStatistic($filters)['not_start']);
                })
                ->addColumn('fail', function ($query) use ($filters){
                    return translatedNumber($query->totalQuizStatistic($filters)['fail']);
                })
                ->addColumn('pass', function ($query) use ($filters) {
                    return translatedNumber($query->totalQuizStatistic($filters)['pass']);
                })
                ->addColumn('pass_rate', function ($query) use ($filters) {
                    $pass = $query->totalQuizStatistic($filters)['pass'];
                    $total = $query->total_enrolled;
                    $percentage = 0;
                    if ($total != 0) {
                        $percentage = ($pass / $total) * 100;
                        if ($percentage > 100) {
                            $percentage = 100;
                        }
                    }
                    return translatedNumber($percentage) . '%';
                })
                ->make(true);
        }elseif($request->type==3){
            return \Yajra\DataTables\Facades\DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('required_type', function ($query) {
                    return $query->required_type == 1 ? trans('courses.Compulsory') : trans('courses.Open');
                })->editColumn('mode_of_delivery', function ($query) {
                    if ($query->mode_of_delivery == 1) {
                        $title = trans('courses.Online');

                    } elseif ($query->mode_of_delivery == 2) {
                        $title = trans('courses.Distance Learning');
                    } else {
                        if (isModuleActive('Org')) {
                            $title = trans('courses.Offline');
                        } else {
                            $title = trans('courses.Face-to-Face');
                        }
                    }
                    return $title;
                })
                ->addColumn('type', function ($query) {
                    return  trans('virtual-class.Virtual Class');

                })
                ->editColumn('total_enrolled', function ($query) use ($filters) {
                    return translatedNumber($query->totalClassStatistic($filters)['total_enroll']);
                })->editColumn('title', function ($query) use ($filters){
                    return $query->title;
                })
                ->addColumn('not_start', function ($query) use ($filters) {
                    return translatedNumber($query->totalClassStatistic($filters)['not_start']);
                })
                ->addColumn('in_process', function ($query) use ($filters) {
                    return translatedNumber($query->totalClassStatistic($filters)['in_process']);
                })
                ->addColumn('finished', function ($query) use ($filters) {
                    return translatedNumber($query->totalClassStatistic($filters)['finished']);
                })
                ->addColumn('finished_rate', function ($query) use ($filters) {
                    $finished = $query->totalClassStatistic($filters)['finished'];
                    $total = $query->total_enrolled;
                    $percentage = 0;
                    if ($total != 0) {
                        $percentage = ($finished / $total) * 100;
                        if ($percentage > 100) {
                            $percentage = 100;
                        }
                    }
                    return translatedNumber(round($percentage)) . '%';
                })
                ->make(true);
        }else{
            return  false;
        }
    }

    public function courseStatisticFilterQuery()
    {
        $query = Course::with('category', 'user', 'enrolls')->whereIn('type', [1,2,3]);
        if (\request('type')) {
            $query->where('type', \request('type'));
        }


        $query->whereHas('enrolls', function ($q) {
            $q->whereHas('user', function ($q2) {

                $user= \request()->get('user');
                $institute = \request()->get('institute');
                if ($user) {
                    $q2->where('id', $user);
                } elseif ($institute) {
                    $q2->where('institute_id', $institute);
                }
                 $q2->where('status', 1);
            });
        });

        if (isInstructor()) {
            $query->where('user_id', '=', Auth::id());
            $query->orWhere('assistant_instructors', 'like', '%"{' . Auth::id() . '}"%');
        }
        return $query;
    }

    public function userWisePerformance(Request $request)
    {
        if ($request->ajax()) {
            return $this->statisticDatatable($request);
        }
        $users =User::where('status', 1)->where('role_id',3)->select('id', 'name')->get();
        return view('backend.report.user_wise_performance',compact('users'));

    }

}
