<?php

namespace App\Http\Controllers;

use App\Events\NewNotification;
use App\Events\OneToOneConnection;
use App\Traits\SendNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Modules\Blog\Entities\Blog;
use Modules\Blog\Http\Controllers\BlogController;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseReveiw;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Entities\LessonQuestion;
use Modules\CourseSetting\Entities\SubCategory;
use Modules\CourseSetting\Http\Controllers\CourseSettingController;
use Modules\Payment\Entities\Cart;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Store\Entities\Product;
use Modules\Survey\Http\Controllers\SurveyController;
use Throwable;


class AjaxController extends Controller
{
    use SendNotification;

    public function topbarEnableDisable(Request $request)
    {
        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;
            $result = DB::table($table)->where('id', $id)->update(['topbar' => $status]);
            if ($result) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'Something went wrong!'], 400);
            }
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function footerEnableDisable(Request $request)
    {

        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;
            $result = DB::table($table)->where('id', $id)->update(['footer' => $status]);
            if ($result) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'Something went wrong!'], 400);
            }
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function statusEnableDisable(Request $request)
    {
        if (appMode()) {
            return response()->json(['warning' => trans('common.For the demo version, you cannot change this')], 200);
        }
        if (!Auth::check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }
        if (Auth::user()->role_id == 3) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }

        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;
            $result=false;
            if (Schema::hasColumn($table, 'status')) {
                $result = DB::table($table)->where('id', $id)->update(['status' => $status]);
            }elseif(Schema::hasColumn($table, 'is_active')){
                $result = DB::table($table)->where('id', $id)->update(['is_active' => $status]);
            }


            //========= End For Chat Module ========

            if ($table == "courses") {
                $course = Course::find($id);
                $course->updated_at = now();
                $course->save();
                // ======= For Chat Module ========
                if (isModuleActive('Chat')) {
                    if ($course && $course->status) {
                        $instructor = User::find($course->user_id);
                        event(new OneToOneConnection($instructor, null, $course));
                    }
                }
                if (isModuleActive('Store')) {
                    if ($course->type == 5) {
                        $product = Product::find($course->product_id);
                        if ($product) {
                            $product->status = $status;
                            $product->save();
                        }
                    }
                }

                if (in_array($course->type, [1, 2])) {
                    $email_template_act = ($course->type == 1) ? ($status == 1 ? 'Course_Publish_Successfully' : 'Course_Unpublished') : ($status == 1 ? 'Quiz_Publish_Successfully' : 'Quiz_Unpublished');
                    $topic_title_key = ($course->type == 1) ? 'course' : 'quiz';

                    $notificationData = [
                        'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                        $topic_title_key => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                    ];
                    $action = [
                        'id' => $course->id,
                        'actionText' => trans('common.View'),
                        'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                        'notificationType' => $email_template_act
                    ];

                    $this->sendNotification($email_template_act, $course->user, $notificationData, $action);


                }


            } elseif ($table == "categories") {
                Cache::forget('categories_' . app()->getLocale() . SaasDomain());
            }  elseif ($table == "course_reveiws") {
                $review =CourseReveiw::with('course')->find($id);
                $course = $review->course;
                $total = CourseReveiw::where('course_id', $course->id)->where('status', 1)->sum('star');
                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
                $average = $count > 0 ? $total / $count : 0;
                $course->reveiw = $average;
                $course->total_rating = $average;
                $course->save();
                (new CourseSettingController())->updateTotalCountForCourse($course);
            } elseif ($table == "currencies") {
                Cache::forget('currencyList_' . SaasDomain());
            } elseif ($table == "country_wish_taxes") {
                Cache::forget('countryWishTaxList_' . SaasDomain());
            } elseif ($table == "sponsors") {
                Cache::forget('SponsorList_' . app()->getLocale() . SaasDomain());
            } elseif ($table == "course_levels") {
                Cache::forget('CourseLevel_' . app()->getLocale() . SaasDomain());
            } elseif ($table == "testimonials") {
                Cache::forget('TestimonialList_' . app()->getLocale() . SaasDomain());
            } elseif ($table == "social_links") {
                Cache::forget('social_links_' . SaasDomain());
            } elseif ($table == "surveys" && $status == 1) {
                $surveyController = new SurveyController();
                $surveyController->sendNotificationToUser($id);
            } elseif ($table == "blogs" && $status == 1) {
                $blogController = new BlogController();
                $blogController->sendNotification($id);
                $blog =Blog::find($id);
                if ($blog){
                    getBlogBonus($blog);
                }

            } elseif ($table == "lesson_questions") {
                if (Settings('real_time_qa_update') == 1) {
                    $parent = LessonQuestion::select('user_id')->find($id);
                    if ($parent) {
                        event(new NewNotification('ChangeStatus', 'Question/Reply Submit', '#', $parent->user_id));
                    }
                }
            }

            if ($result) {
                return response()->json(['success' => trans('common.Status has been changed')]);
            } else {
                return response()->json(['error' => trans('common.Something went wrong') . '!'], 400);
            }
        } catch (QueryException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function publishEnableDisable(Request $request)
    {
        try {
            $id = $request->id;
            $table = $request->table;
            $status = $request->status;
            $result = DB::table($table)->where('id', $id)->update(['publish' => $status]);
            if ($result) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['error' => 'Something went wrong!'], 400);
            }
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            Log::error($errorMessage);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function ajaxGetSubCategoryList(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->id)->get();
        return response()->json([$subcategories]);
    }


    public function ajaxGetCourseList(Request $request)
    {
        try {
            $category_id = $request->category_id;
            $subcategory_id = $request->subcategory_id;
            if (Auth::user()->role_id == 1) {
                $query = Course::select('id', 'title');
                if ($category_id) {
                    $query->where('category_id', $category_id);
                }
                if ($subcategory_id) {
                    $query->where('subcategory_id', $subcategory_id);
                }
                $subcategories = $query->get();

            } else {
                $subcategories = Course::select('id', 'title')->where('category_id', $category_id)->where('subcategory_id', $subcategory_id)->where('user_id', Auth::user()->id)->get();
            }
            $courses = [];
            foreach ($subcategories as $key => $subcategory) {
                $title = $subcategory->title;
                $courses[$key] = $subcategory;
                $courses[$key]->title2 = $title;
            }

            return response()->json([$courses]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function ajaxGetQuizList(Request $request)
    {
        try {

            $quiz_list = OnlineQuiz::query();
            if ($request->category_id != "") {
                $quiz_list->where('category_id', $request->category_id);
            }
            if ($request->subcategory_id != "") {
                $quiz_list->where('sub_category_id', $request->subcategory_id);
            }
            if ($request->course_id != "") {
                $quiz_list->where('course_id', $request->course_id);
            }


            $quiz_list = $quiz_list->with('category', 'subCategory', 'course')->get();

            return response()->json([$quiz_list]);
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function updateActivity()
    {
//        if ((int)Settings('device_limit_time') == 0) {
//            return false;
//        }
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_activity_at = now();
            $user->save();
        }
        return true;
    }

    public function get_preview_modal($id)
    {
        if (Settings('frontend_active_theme') == 'edume') {
            $lesson = Lesson::find($id);
            $course = $lesson->course;
            return View::make('frontend.edume.partials._course_preview_modal', [
                'lesson' => $lesson,
                'course' => $course
            ]);
        } else {
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    public function get_cart_price()
    {
        $price = 0;
        if (Auth::check()) {
            $carts = Cart::where('user_id', Auth::user()->id)->get();

            foreach ($carts as $cart) {
                $price += $cart->price;
            }
        } else {
            $carts = session()->get('cart');
            if (isset($carts)) {
                foreach ($carts as $cart) {
                    $price = $price + $cart['price'];
                }
            }
        }
        return response()->json($price);
    }
}
