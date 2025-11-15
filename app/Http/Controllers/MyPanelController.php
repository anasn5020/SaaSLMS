<?php

namespace App\Http\Controllers;

use App\DepositRecord;
use App\Repositories\MyEnrollmentRepository;
use App\Traits\ImageStore;
use App\User;
use App\UserLogin;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\Coupons\Entities\UserWiseCoupon;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseCanceled;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Noticeboard\Entities\Noticeboard;
use Modules\OrgInstructorPolicy\Entities\OrgPolicyCategory;
use Modules\Payment\Entities\Checkout;
use Modules\PaymentMethodSetting\Entities\PaymentMethod;
use Modules\Store\Entities\CancelReason;
use Modules\Store\Entities\DeliveryProcess;
use Modules\Store\Entities\ImageRefundRequest;
use Modules\Store\Entities\OrderPackageDetail;
use Modules\Store\Entities\Product;
use Modules\Store\Entities\RefundProcess;
use Modules\Store\Entities\RefundProduct;
use Modules\Store\Entities\RefundReason;
use Modules\Store\Entities\RefundRequest;
use Modules\Store\Entities\RefundRequestDetail;
use Modules\Store\Entities\ShippingConfiguration;
use Modules\Store\Entities\ShippingMethod;
use Modules\Store\Entities\StoreBankPayment;
use Yajra\DataTables\Facades\DataTables;

class MyPanelController extends Controller
{
    use ImageStore;

    public $myEnrollmentRepo;

    public function __construct(MyEnrollmentRepository $myEnrollmentRepo)
    {
        $this->myEnrollmentRepo = $myEnrollmentRepo;
        $this->middleware('RoutePermissionCheck:users.my_refund.index', ['only' => ['myRefund', 'myRefundeDatatable']]);
        $this->middleware('RoutePermissionCheck:users.my_purchase.index', ['only' => ['myPurchase', 'myPurchaseDatatable']]);
        $this->middleware('RoutePermissionCheck:users.my_referral.index', ['only' => ['myReferral', 'myReferralDatatable']]);
        $this->middleware('RoutePermissionCheck:users.logged_in_devices.index', ['only' => ['loggedInDevices', 'loggedInDevicesDatatable']]);
        $this->middleware('RoutePermissionCheck:users.my_certificates.index', ['only' => ['myCertificates', 'myCertificatesDatatable']]);
        $this->middleware('RoutePermissionCheck:users.deposit.index', ['only' => ['deposit', 'depositDatatable']]);
        $this->middleware('RoutePermissionCheck:users.my_topics.index', ['only' => ['myTopics', 'myTopicsDatatable']]);

    }

    public function my_store_purchase_order_detail($id)
    {
        $data['enroll'] = Checkout::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->with('courses', 'user', 'courses.course.enrollUsers', 'bill')->first();
        if (!$data['enroll']) {
            abort(404);
        }
        $data['order_status'] = [];
        $data['order'] = Checkout::find($id);
        $data['packages'] = OrderPackageDetail::with('product_details.getCourse', 'products.course')->where('order_id', $id)->groupby('seller_id')->distinct()->get();
        $data['processes'] = DeliveryProcess::all();
        $data['cancel_reasons'] = CancelReason::all();
        return view('backend.my_panel.my_purchase.purchase_details', $data);
    }

    public function refund_instructor_make_request($ref_id)
    {

        $id = decrypt($ref_id);
        $data['order_status'] = [];
        $data['order'] = Checkout::find($id);
        $data['enroll'] = $data['order'];
        $data['package'] = OrderPackageDetail::with('product_details.getCourse', 'products.course')->find($id);
        $data['processes'] = DeliveryProcess::all();
        $data['reasons'] = RefundReason::all();
        $data['cancel_reasons'] = CancelReason::all();

        return view('backend.my_panel.my_purchase.instructor_purchase_order_details', $data);
    }

    public function myRefundDispute()
    {
        try {

            return view('backend.my_panel.my_purchase.instructor_refund_dispute');

            // return view(theme('pages.myRefundDispute'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myRefundDisputeDatatable(Request $request)
    {
        try {
            $data = RefundRequest::with('refund_details', 'refund_details.refund_products', 'order')
                ->where('customer_id', auth()->id());

            // If you're using DataTables' search and sort functionality, you can apply the order dynamically
            if ($request->has('order')) {
                $orderColumnIndex = $request->get('order')[0]['column'];
                $orderDirection = $request->get('order')[0]['dir']; // asc or desc

                $columns = ['id', 'updated_at', 'created_at']; // List of sortable columns (adjust according to your table)
                $orderColumn = $columns[$orderColumnIndex] ?? 'id'; // Default ordering column is 'id'

                $data = $data->orderBy($orderColumn, $orderDirection);
            } else {
                // Default ordering if no sorting parameter is passed
                $data = $data->orderBy('id', 'asc');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function ($row) {
                    return showDate($row->updated_at);
                })
                ->addColumn('order_number', function ($row) {
                    return @$row->order->order_number;
                })
                ->addColumn('status', function ($row) {
                    return @$row->CheckConfirmed;
                })
                ->addColumn('request_sent_date', function ($row) {
                    return showDate(@$row->created_at);
                })
                ->addColumn('purchase_price', function ($row) {
                    return getPriceFormat($row->total_return_amount);
                })
                ->addColumn('action', function ($row) {
                    return view('backend.my_panel.my_purchase.components._action_td', ['row' => $row]);
                })
                ->rawColumns(['action'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    public function instructor_refund_show($id)
    {
        try {

            $data['cancel_reasons'] = CancelReason::all();
            $data['refund_request'] = RefundRequest::with('refund_details', 'refund_details.refund_products', 'order')->findOrFail($id);
            $data['processes'] = RefundProcess::all();

            $data['enroll'] = Checkout::where('id', $data['refund_request']->order_id)
                ->where('user_id', Auth::user()->id)
                ->with('courses', 'user', 'courses.course.enrollUsers', 'bill')->first();
            return view('backend.my_panel.my_purchase.instructor_refund_dispute_details', $data);
            // return view(theme('pages.myRefundDisputeDetails'), compact('id'));
        } catch (\Exception $e) {
            return back();
        }
    }

    public function myRefund()
    {
        try {
            $flag = Settings('allow_refund_days') == 0 ? false : true;


            $ignore = CourseCanceled::where('user_id', auth()->id())
                ->where('status', 0)
                ->whereNotNull('enroll_id')->pluck('enroll_id')->toArray();
            $data['courses'] = CourseEnrolled::where('user_id', auth()->id())
                ->where('purchase_price', ">", 0)
                ->whereNotIn('id', $ignore)
                ->when($flag, function ($query) {
                    $today = Carbon::now();
                    $date = $today->subDays((int)Settings('allow_refund_days'))->format('Y-m-d');
                    return $query->where(DB::raw('DATE(created_at)'), '>=', $date);
                })
                ->with('course')
                ->get();

            return view('backend.my_panel.my_refund.index', $data);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function myRefundeDatatable(Request $request)
    {
        try {
            $data = CourseCanceled::query()
                ->where('user_id', auth()->id())
                ->with('course');

            if ($request->f_date) {
                $data->whereBetween(DB::raw('DATE(created_at)'), formatDateRangeData($request->f_date));
            }


            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return showDate($row->created_at);
                })
                ->addColumn('course', function ($row) {
                    return $row->course->title;
                })
                ->editColumn('purchase_price', function ($row) {
                    return getPriceFormat($row->purchase_price);
                })
                ->editColumn('type', function ($row) {
                    return $row->refund == 1 ? 'Refund' : 'Cancel';
                })
                ->editColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return 'Approved';
                    } elseif ($row->status == 0) {
                        return 'Pending';
                    } else {
                        return 'Reject';
                    }
                })
                ->addColumn('action', function ($row) {
                    return view('backend.my_panel.my_refund.components._action', ['row' => $row]);
                })
                ->rawColumns(['action'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    public function myPurchase()
    {
        try {
            return view('backend.my_panel.my_purchase.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function myPurchaseDatatable(Request $request)
    {
        try {
            $data = Checkout::query()
                ->where('user_id', Auth::id())
                ->where('status', 1)
                ->with('coupon', 'courses')->latest();


            if ($request->f_date) {
                $data->whereBetween(DB::raw('DATE(updated_at)'), formatDateRangeData($request->f_date));

            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('updated_at', function ($row) {
                    return showDate($row->updated_at);
                })
                ->addColumn('total_courses', function ($row) {
                    if (isModuleActive('Store')) {
                        return $row->courses->sum('qty');
                    } else {
                        if (count($row->courses) == 0) {
                            return 1;
                        } else {
                            return count($row->courses);
                        }
                    }

                })
                ->addColumn('order_number', function ($row) {
                    return @$row->order_number;
                })
                ->addColumn('delivery_fee', function ($row) {
                    if (isModuleActive('Store')) {
                        return getPriceFormat(@$row->shipping->cost);
                    } else {
                        return '';
                    }
                })
                ->editColumn('purchase_price', function ($row) {
                    return getPriceFormat($row->purchase_price);
                })
                ->editColumn('discount', function ($row) {
                    return $row->discount != 0 ? getPriceFormat($row->discount) : '';
                })
                ->addColumn('tax', function ($row) {
                    if (hasTax() && $row->tax) {
                        return getPriceFormat($row->tax);
                    }
                })
                ->addColumn('invoice', function ($row) {
                    return view('backend.my_panel.my_purchase.components._invoice', ['row' => $row]);
                })
                ->rawColumns(['invoice'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    public function myReferral()
    {
        try {
            if (!Auth::user()->referral) {
                User::where('id', Auth::id())->update(['referral' => generateUniqueId()]);
            }

            return view('backend.my_panel.my_referral.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function myReferralDatatable(Request $request)
    {
        try {
            $data = UserWiseCoupon::query()->with(['invite_accept_byF'])->where('invite_by', Auth::user()->id)
                ->where('course_id', '!=', null);

            if ($request->f_date) {
                $data->whereHas('invite_accept_byF', function ($q) use ($request) {
                    $q->whereBetween(DB::raw('DATE(created_at)'), formatDateRangeData($request->f_date));
                });

            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('bonus_amount', function ($row) {
                    return showPrice($row->bonus_amount);
                })
                ->addColumn('date', function ($row) {
                    return showDate($row->invite_accept_byF->created_at);
                })
                ->addColumn('user', function ($row) {
                    return view('backend.my_panel._user_td', ['row' => $row->invite_accept_byF]);
                })
                ->rawColumns(['user'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    public function myCertificates()
    {
        try {
            return view('backend.my_panel.my_certificates.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function myCertificatesDatatable(Request $request)
    {
        try {
            $data = CertificateRecord::query()->with(['course', 'student'])->when(isModuleActive('CPD'), function ($q) {
                $q->whereNotNull('course_id');
            })->where('student_id', Auth::user()->id);


            if ($request->f_date) {
                $data->whereBetween(DB::raw('DATE(created_at)'), formatDateRangeData($request->f_date));
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('course', function ($row) {
                    $course = $row->course;
                    return "<a href=" . courseDetailsUrl($course->id, $course->type, $course->slug) . " > $course->title </a>";
                })
                ->editColumn('created_at', function ($row) {
                    return showDate($row->created_at);
                })
                ->addColumn('my_class', function ($row) {
                    return view('backend.my_panel.my_certificates.components._my_class', ['certificate' => $row]);
                })
                ->addColumn('invoice', function ($row) {
                    return view('backend.my_panel.my_certificates.components._invoice', ['certificate' => $row]);
                })
                ->addColumn('action', function ($row) {
                    return view('backend.my_panel.my_certificates.components._action', ['certificate' => $row]);
                })
                ->rawColumns(['action', 'course', 'my_class', 'invoice'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    public function loggedInDevices()
    {
        try {
            return view('backend.my_panel.logged_in_device.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function loggedInDevicesDatatable(Request $request)
    {
        try {
            $data = UserLogin::query()->where('user_id', auth()->id())->where('status', 1);


            if ($request->f_date) {
                $data->whereBetween(DB::raw('DATE(login_at)'), formatDateRangeData($request->f_date));
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('login_at', function ($row) {
                    return showDate($row->login_at);
                })
                ->editColumn('logout_at', function ($row) {
                    return $row->logout_at ? showDate($row->logout_at) : trans('common.Active');
                })
                ->addColumn('action', function ($row) {
                    return view('backend.my_panel.logged_in_device.components._action', ['login' => $row]);
                })
                ->rawColumns(['action'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    public function deposit(Request $request)
    {
        try {
            $data['methods'] = PaymentMethod::where('active_status', 1)->where('module_status', 1)->where('method', '!=', 'Wallet')->where('method', '!=', 'Offline Payment')->get(['method', 'logo']);
            $data['amount'] = isset($request->deposit_amount) ? $request->deposit_amount : null;
            return view('backend.my_panel.deposit.index', $data);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function depositDatatable(Request $request)
    {
         try {
            $data = DepositRecord::query()->where('user_id', Auth::id());
            if ($request->f_date) {
                $data->whereBetween(DB::raw('DATE(created_at)'), formatDateRangeData($request->f_date));
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return showDate($row->created_at);
                })
                ->editColumn('amount', function ($row) {
                    return showPrice($row->amount);
                })
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }


    public function myTopics()
    {
        try {
            $categories = Category::where('status', 1)->orderBy('position_order', 'ASC');
            if (isModuleActive('OrgInstructorPolicy') && \auth()->user()->role_id != 1) {
                $assign = OrgPolicyCategory::where('policy_id', \auth()->user()->policy_id)->pluck('category_id')->toArray();
                $categories->whereIn('id', $assign);
            }
            $data['categories'] = $categories->with('parent')->get();
            return view('backend.my_panel.my_topics.index', $data);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myTopicsDatatable(Request $request)
    {
        try {
            $data = $this->myEnrollmentRepo->myTopics($request->all());
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('topic_title', function ($row) {
                    $course = $row->course;
                    return "<a href=" . courseDetailsUrl($course->id, $course->type, $course->slug) . " > $course->title </a>";
                })
                ->addColumn('topic_type', function ($row) {
                    return $row->course->courseType();
                })
                ->editColumn('created_at', function ($row) {
                    return showDate($row->created_at);
                })
                ->addColumn('curriculum', function ($row) {
                    $result = '';
                    if ($row->course->type == 1) {
                        $result = count($row->course->lessons) . ' ' . trans('student.Lessons');
                    } elseif ($row->course->type == 2) {
                        $result = count($row->course->quiz->assign) . ' ' . trans('student.Question');
                    } elseif ($row->course->type == 3) {
                        $result = $row->course->class->total_class . ' ' . trans('student.Classes');
                    }
                    return $result;
                })
                ->addColumn('action', function ($row) {
                    return view('backend.my_panel.my_topics.components._action', ['course' => $row->course]);
                })
                ->rawColumns(['action', 'topic_title'])
                ->toJson();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 503);
        }
    }

    public function myNoticeboard(Request $request)
    {
        try {
            $user = Auth::user();
            $courseId = $user->studentCourses->pluck('course_id')->toArray();
            $query = \Modules\Noticeboard\Entities\Noticeboard::where('status', 1)->with('noticeType');

            if (isModuleActive('Organization') && !empty($user->organization_id)) {
                $query->whereHas('user', function ($q) use ($user) {
                    $q->where('id', $user->organization_id);
                });
            }

            $data['noticeboards'] = $query->whereHas('assign', function ($q) use ($courseId, $user) {
                $q->whereIn('course_id', $courseId);
                $q->orWhere('role_id', $user->role_id);
            })->latest()->paginate(20);
            return view('noticeboard::noticeboard_list', $data);

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function showNoticeboard($id)
    {
        try {
            $user = Auth::user();
            $courseIds = Auth::user()->studentCourses->pluck('course_id')->toArray();
            $noticeboard = Noticeboard::where('status', 1)->with('noticeType', 'assign', 'assign.course')
                ->whereHas('assign', function ($q) use ($courseIds, $user) {
                    $q->whereIn('course_id', $courseIds);
                    $q->orWhere('role_id', $user->role_id);
                })->findOrFail($id);
            return view('noticeboard::_noticeboard_modal', compact('noticeboard', 'courseIds'));
        } catch (\Exception $e) {
            return response([], 404);
        }
    }

    public function changeReceiveStatusByCustomer(Request $request)
    {
        try {
            $order = Checkout::findOrFail($request['order_id']);
            $order->is_received = 1;
            $order->order_status = 5;
            $order->is_completed = 1;
            $order->save();
            $package = OrderPackageDetail::findOrFail($request['package_id']);
            $package->delivery_status = 5;
            $package->save();
            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function instructor_refund_make_request_store(Request $request)
    {
        if ($request->product_images_) {
            foreach ($request->product_images_ as $product) {
                $request->validate([
                    'product_images_' . $product . '.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,tif,bmp,ico,psd,webp',
                ]);
            }
        }

        if (empty($request->product_ids)) {
            Toastr::error(__('product.select_product_first'));
            return back();
        }
        DB::beginTransaction();
        try {
            $data = $request->all();

            $package = OrderPackageDetail::find($data['package_id']);
            $shippingMethod = null;
            if ($package) {
                $shippingMethod = ShippingMethod::find($package->shipping_method);
            } else {
                Toastr::error(trans('frontend.Invalid Request'));
                return redirect()->back();
            }


            $total_return_amount = 0;

            $refund_request = new RefundRequest();
            $refund_request->customer_id = auth()->user()->id;
            $refund_request->order_id = $data['order_id'];
            $refund_request->refund_method = $data['money_get_method'];
            $refund_request->shipping_method = $data['shipping_way'];
            if ($data['shipping_way'] == "courier") {
                $refund_request->shipping_method_id = $shippingMethod->id;
                $refund_request->pick_up_address_id = $data['pick_up_address_id'];
            } else {
                $refund_request->shipping_method_id = $shippingMethod->id;
                $refund_request->drop_off_address = $data['drop_off_courier_address'];
            }
            $refund_request->additional_info = $data['additional_info'];
            $refund_request->save();

            if (@$data['product_images_']) {
                foreach ($data['product_images_'] as $image) {
                    if ($image) {
                        $imagename = $this->saveImage($image);;
                        ImageRefundRequest::create([
                            'refund_request_id' => $refund_request->id,
                            'image' => $imagename,
                        ]);
                    }
                }
            }

            // till this end

            if ($data['money_get_method'] == "bank_transfer") {
                StoreBankPayment::create([
                    'itemable_id' => $refund_request->id,
                    'itemable_type' => RefundRequest::class,
                    'bank_name' => $data['bank_name'],
                    'branch_name' => $data['branch_name'],
                    'account_number' => $data['account_no'],
                    'account_holder' => $data['account_name'],
                ]);
            }
            foreach ($data['product_ids'] as $key => $send_product_id) {
                $split = explode('-', $send_product_id);

                $package[$key] = $split[0];
                $product[$key] = $split[1];
                $amount[$key] = $split[2];
                $course[$key] = $split[3];

                $request_detail_info = [
                    "refund_request_id" => $refund_request->id,
                    "order_package_id" => $package->id,
                    "seller_id" => $package->seller->id
                ];
                $refund_request_details = RefundRequestDetail::updateOrCreate($request_detail_info);
                $request_product_info = [
                    'refund_request_detail_id' => $refund_request_details->id,
                    'product_id' => $product[$key],
                    'refund_reason_id' => $data['reason_id'][$key],
                    'return_qty' => $data['qty'][$key],
                    'return_amount' => $amount[$key] * $data['qty'][$key],

                ];
                $request_product = RefundProduct::Create($request_product_info);
                $total_return_amount += $request_product->return_amount;
            }
            $shipping_configuration = ShippingConfiguration::where('seller_id', $package->seller->id)->first();
            $refund_quantity = $refund_request_details->refund_products->sum('return_qty');
            $package_product_qty = $package->products->sum('qty');
            if ($refund_quantity == $package_product_qty) {

                $shipping_cost = 0;

                if (!isModuleActive('Store')) {
                    $refund_request->update([
                        'total_return_amount' => $total_return_amount + $shipping_cost
                    ]);
                } else {
                    $refund_request->update([
                        'total_return_amount' => $total_return_amount + $shipping_cost + $package->tax_amount
                    ]);
                }
            } else {
                $refund_request->update([
                    'total_return_amount' => $total_return_amount
                ]);
            }

            DB::commit();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('users.store_refund_dispute.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('common.Something Went Wrong',trans('common.Error')));
            return back();
        }
    }

    public function my_virtual_file_download($id)
    {
        try {
            $data['packages'] = OrderPackageDetail::with('course')->where('order_id', $id)->get();
            return view('backend.my_panel.my_purchase.virtual_file_index', $data);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function downloadVirtualFile($slug)
    {
        try {
            $course = Course::where('slug', $slug)->first();
            $product = Product::find($course->product_id);
            $file_path = $product->soft_file;

            return response()->download($file_path);
        } catch (\Exception $e) {
            return back();
        }
    }

}
