<?php

namespace App\Http\Controllers\Api;

use App\Events\OneToOneConnection;
use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\Course\ClassDetailResource;
use App\Http\Resources\api\v1\Course\CoursesDetailResource;
use App\Http\Resources\api\v1\Course\CoursesResource;
use App\Http\Resources\api\v1\Course\PopularCoursesResource;
use App\Http\Resources\api\v1\Course\QuizDetailResource;
use App\Http\Resources\api\v1\Course\Lesson\QuizDetailResource as LessonQuizDeatialResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Modules\Affiliate\Events\ReferralPayment;
use Modules\Certificate\Entities\Certificate;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\Localization\Entities\Language;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizTest;
use Modules\Survey\Entities\Survey;
use Modules\Survey\Http\Controllers\SurveyController;

/**
 * @group  Course management
 *
 * APIs for managing course
 */
class CourseApiController extends Controller
{

    public function __construct()
    {
        config(['auth.defaults.guard' => 'api']);
    }

    /**
     * Get all courses
     *
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:40 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * }
     * ],
     * "total": 11,
     * "message": "Getting Courses Data"
     * }
     *
     */
    public function getAllCourses(Request $request)
    {
        $courses = Course::where('type', 1)
            ->where('status', 1)
            ->where('scope', 1)
            ->when($search = $request->search, function ($courses) use ($search) {
                $courses->whereLike('title', $search);
            })
            ->when($category = $request->category, function ($courses) use ($category) {
                $courses->where(function ($courses) use ($category) {
                    $courses->where('category_id', $category);
                    $courses->orWhere('subcategory_id', $category);
                });
            })
            ->when($level = $request->level, function ($courses) use ($level) {
                $courses->where('level', $level);
            })
            ->when($language = $request->language, function ($courses) use ($language) {
                $courses->where('lang_id', $language);
            })
            ->when($request->price == 'free', function ($courses) {
                $courses->where('price', 0);
            })
            ->with('courseLevel')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => CoursesResource::collection($courses),
            'message' => 'Getting Courses Data',
        ]);
    }

    public function getCoursesByCategory(Request $request)
    {
        $courses = Course::where('type', 1)
            ->where('status', 1)
            ->where('scope', 1)
            ->when($category = $request->category, function ($courses) use ($category) {
                $courses->where('category_id', $category);
            })
            ->with('courseLevel')
            ->latest()
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => CoursesResource::collection($courses),
            'message' => 'Getting Courses Data',
        ]);
    }

    public function getAllClasses(Request $request)
    {
        $courses = Course::where('type', 3)
            ->where('scope', 1)
            ->where('status', 1)
            ->when($search = $request->search, function ($courses) use ($search) {
                $courses->whereLike('title', $search);
            })
            ->with('courseLevel')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => CoursesResource::collection($courses),
            'message' => 'Getting Class Data',
        ]);
    }


    /**
     * Get all quizzes
     *
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "class_id": null,
     * "user_id": 1,
     * "lang_id": 19,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/frontend/infixlmstheme/img/course/1.jpg",
     * "thumbnail": "public/frontend/infixlmstheme/img/course/1.jpg",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "3rd Mar, 2021",
     * "publishedDate": "3rd Mar, 2021",
     * "sumRev": 0,
     * "purchasePrice": 0,
     * "enrollCount": 1,
     * "enrolls": [
     * {
     * "id": 1,
     * "tracking": "K3USKPJBC5U8",
     * "user_id": 3,
     * "course_id": 1,
     * "purchase_price": 0,
     * "coupon": null,
     * "discount_amount": 0,
     * "status": 1,
     * "reveune": 0,
     * "reason": null,
     * "created_at": "2021-03-03T07:32:13.000000Z",
     * "updated_at": "2021-03-03T07:32:13.000000Z",
     * "enrolledDate": "3rd March 2021 13:13 pm"
     * }
     * ]
     * }
     * ],
     * "total": 1,
     * "message": "Getting Courses Data"
     * }
     * @return [json] user object
     */
    public function getAllQuizzes(Request $request)
    {
        $courses = Course::where('type', 2)
            ->where('scope', 1)
            ->where('status', 1)
            ->when($search = $request->search, function ($courses) use ($search) {
                $courses->whereLike('title', $search);
            })
            ->with('courseLevel')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => CoursesResource::collection($courses),
            'message' => 'Getting Quiz Data',
        ]);
    }


    /**
     * Get Course Details
     *
     * @response
     * {
     * "success": true,
     * "data": {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:41 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * },
     * "message": "Getting Course Data"
     * }
     *
     */
    public function getCourseDetails($id)
    {
        updateEnrolledCourseLastView($id);

        $course = Course::with('courseLevel', 'user', 'chapters', 'lessons', 'lessons.quiz', 'files')->findOrFail($id);
        $course->total_percentage = $course->loginUserTotalPercentage;
        if (auth('api')->user() != null) {
            $course->isEnrolled = (!$course->isLoginUserEnrolled) ? false : true;

            if ($course->type == 1)
                $course->certificate = Certificate::where('for_course', 1)->first();
            else
                $course->certificate = Certificate::where('for_quiz', 1)->first();


            $course->quizPass = true;
            $hasQuiz = QuizTest::where('course_id', $course->id)->where('user_id', auth('api')->user()->id)->groupBy('quiz_id')->get();
            $hasPassQuiz = QuizTest::where('course_id', $course->id)->where('user_id', auth('api')->user()->id)->where('pass', 1)->groupBy('quiz_id')->get();

            if (count($hasQuiz) != count($hasPassQuiz)) {
                $course->quizPass = false;
            }

            if (isModuleActive('Survey')) {
                $survey = Survey::where('course_id', $course->id)->with('questionAssigns', 'questionAssigns.questionBank', 'questionAssigns.questionBank.questionMu')->first();
                if ($survey) {
                    $survey->course_title = $course->title;
                    $survey->participateStatus = $survey->loginUserParticipant();
                    $course->survey_attend_before_certificate = Settings('must_survey_before_certificate') ? true : false;
                    $course->survey = $survey;
                    $particants = $survey->participants->where('user_id', auth('api')->user()->id)->first();

                    if ($particants) {
                        $course->attendSurvey = true;
                    } else {
                        $course->attendSurvey = false;
                    }
                }
            }
            foreach ($course->lessons as $key => $singleLesson) {
                $singleLesson->isComplete = $singleLesson->completed && $singleLesson->completed->status == 1 ? true : false;
            }
        }


        $reviews = DB::table('course_reveiws')
            ->select(
                'course_reveiws.id',
                'course_reveiws.star',
                'course_reveiws.comment',
                'course_reveiws.created_at',
                'course_reveiws.status',
                'users.id as userId',
                'users.name as userName',
                'users.image as userImage',
            )
            ->join('users', 'users.id', '=', 'course_reveiws.user_id')
            ->where(function ($query) {
                $query->where('course_reveiws.status',1)
                    ->orWhere('course_reveiws.user_id',auth()->id());
            })
            ->where('course_reveiws.course_id', $id)->get();

        $course->reviews = $reviews;
        $course->review = round($course->review, 1);

        $course->comments = CourseComment::where('course_id', $id)
            ->where(function ($query) {
                $query->where('status',1)
                    ->orWhere('user_id',auth()->id());
            })
            ->with('replies', 'replies.user', 'user')->get();

        foreach ($course->comments as $comment) {
            $comment->canDelete = commentCanDelete($comment->id, $comment->instructor_id);

            foreach ($comment->replies as $replay) {
                $replay->canDeleteReply = ReplyCanDelete($replay->user_id, $course->user_id);
            }
        }


        if ($course) {
            if (isModuleActive('OrgSubscription') && auth('api')->check()) {
                if (!orgSubscriptionCourseValidity($id)) {
                    $response = [
                        'success' => false,
                        'data' => new CoursesDetailResource($course),
                        'message' => trans('org-subscription.Your Subscription Expire'),
                    ];
                    // return response()->json($response, 200);
                }
            }
            if (isModuleActive('OrgSubscription') && auth('api')->check()) {
                if (!orgSubscriptionCourseSequence($id)) {
                    $response = [
                        'success' => false,
                        'data' => new CoursesDetailResource($course),
                        'message' => trans('org-subscription.You Can Not Continue This . Pls Complete Previous Course'),
                    ];
                    // return response()->json($response, 200);
                }
            }
            if (isModuleActive('BundleSubscription')) {
                if (isBundleExpire($id)) {
                    $response = [
                        'success' => false,
                        'data' => new CoursesDetailResource($course),
                        'message' => 'Your bundle validity expired', 'Access Denied',
                    ];
                    // return response()->json($response, 200);
                }
            }

            $response = [
                'success' => true,
                'data' => new CoursesDetailResource($course),
                'message' => 'Getting Course Data',
            ];
            // return response()->json($response, 200);
        } else {
            $response = [
                'success' => false,
                'message' => 'No Course Found',
            ];
            // return response()->json($response, 200);
        }
        return response()->json($response);
    }


    public function getClassDetails($id)
    {
        $relation = [
            'courseLevel',
            'user',
            'class.zoomMeetings',
            'class.customMeetings',
        ];

        if (isModuleActive("BBB")) {
            $relation[] = 'class.bbbMeetings';
        }
        if (isModuleActive("Jitsi")) {
            $relation[] = 'class.jitsiMeetings';
        }
        $course = Course::with($relation)->where('type', 3)->find($id);
        if (auth('api')->user() != null) {
            $course->isEnrolled = !!$course->isLoginUserEnrolled;
        }

        $reviews = DB::table('course_reveiws')
            ->select(
                'course_reveiws.id',
                'course_reveiws.star',
                'course_reveiws.comment',
                'course_reveiws.created_at',
                'course_reveiws.status',
                'users.id as userId',
                'users.name as userName',
                'users.image as userImage',
            )
            ->join('users', 'users.id', '=', 'course_reveiws.user_id')
            ->where(function ($query) {
                $query->where('course_reveiws.status',1)
                    ->orWhere('course_reveiws.user_id',auth()->id());

            })
            ->where('course_reveiws.course_id', $id)->get();

        $course->reviews = $reviews;
        $course->review = round($course->review, 1);
        $course->comments = CourseComment::where('course_id', $id)
            ->where(function ($query) {
                $query->where('status',1)
                    ->orWhere('user_id',auth()->id());
            })
            ->with('replies', 'replies.user', 'user')->get();

        foreach ($course->comments as $comment) {
            $comment->canDelete = commentCanDelete($comment->id, $comment->instructor_id);

            foreach ($comment->replies as $replay) {
                $replay->canDeleteReply = ReplyCanDelete($replay->user_id, $course->user_id);
            }
        }

        if ($course->class->host == 'Custom') {
            foreach ($course->class->customMeetings as $meeting) {
                $meeting->current_date_time_utc = now()->utc()->toDateTimeString();
            }
        }

        if ($course) {
            $response = [
                'success' => true,
                'data' => new ClassDetailResource($course),
                'message' => 'Getting Course Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Course Found',
            ];
            $status = 404;
        }

        return response()->json($response, $status ?? 200);
    }


    /**
     * Get Quiz Details
     *
     * @response
     * {
     * "success": true,
     * "data": {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:41 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * },
     * "message": "Getting Quiz Data"
     * }
     */
    public function getQuizDetails($id)
    {
        $relation = ['courseLevel', 'user', 'quiz', 'quiz.assign', 'quiz.assign.questionBank', 'quiz.assign.questionBank.questionMu', 'quiz.assign.questionBank.questionMuInSerial'];

        $user = auth('api')->user();
        $course = Course::with($relation)->where('type', 2)->find($id);
        if ($user != null) {
            $course->isEnrolled = !!$course->isLoginUserEnrolled;
        }

        $course->level = CourseLevel::where('status', 1)->where('id', $course->level)->select('id', 'title')->first();
        $reviews = DB::table('course_reveiws')
            ->select(
                'course_reveiws.id',
                'course_reveiws.star',
                'course_reveiws.comment',
                'course_reveiws.created_at',
                'course_reveiws.status',
                'users.id as userId',
                'users.name as userName',
                'users.image as userImage',
            )
            ->join('users', 'users.id', '=', 'course_reveiws.user_id')
            ->where(function ($query) {
                $query->where('course_reveiws.status',1)
                    ->orWhere('course_reveiws.user_id',auth()->id());

            })
            ->where('course_reveiws.course_id', $id)->get();

        $course->reviews = $reviews;
        $course->review = round($course->review, 1);
        $course->comments = CourseComment::where('course_id', $id)
            ->where(function ($query) {
                $query->where('status',1)
                    ->orWhere('user_id',auth()->id());
            })
            ->with('replies', 'replies.user', 'user')->get();

        foreach ($course->comments as $comment) {
            $comment->canDelete = commentCanDelete($comment->id, $comment->instructor_id);

            foreach ($comment->replies as $replay) {
                $replay->canDeleteReply = ReplyCanDelete($replay->user_id, $course->user_id);
            }
        }

        if (!empty($course->duration)) {
            $timer = $course->duration;
        } else {
            if (!empty($course->quiz->question_time_type == 1)) {
                $timer = $course->quiz->question_time;
            } else {
                $timer = $course->quiz->question_time * count($course->quiz->assign);
            }
        }
        //advance quiz start
        if (isModuleActive('AdvanceQuiz') && $user) {
            $last_given_quiz = QuizTest::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('quiz_id', $course->quiz_id)
                ->with('details', 'details.answers')
                ->latest()->first();

            if ($last_given_quiz && $last_given_quiz->state != 2 && $last_given_quiz->continue_do_test == 1) {

                $reminder_time = $last_given_quiz->extra_time;

                $start_time = Carbon::parse($last_given_quiz->start_at);
                $end_time = Carbon::parse($last_given_quiz->start_at)->addSeconds($last_given_quiz->duration * 60);
                $last_time = $end_time->diffInSeconds($start_time);

                $timer = (($timer + $reminder_time) * 60) - $last_time;
                //    $timer = $timer != 0 ? $timer / 60 : 0;
                $timer = (int)$timer != 0 ? $timer / 60 : 0;
                $course->quiz->last_given_quiz = $last_given_quiz;
            }
        }
        //advance quiz end
        $course->quiz->question_time = (string)$timer;

        if ($course) {
            if (isModuleActive('OrgSubscription') && auth('api')->check()) {
                if (!orgSubscriptionCourseValidity($id)) {
                    $response = [
                        'success' => false,
                        'data' => $course,
                        'message' => trans('org-subscription.Your Subscription Expire'),
                    ];
                    return response()->json($response, 200);
                }
                if (!orgSubscriptionCourseSequence($id)) {
                    $response = [
                        'success' => false,
                        'data' => $course,
                        'message' => trans('org-subscription.You Can Not Continue This . Pls Complete Previous Course'),
                    ];
                    return response()->json($response, 200);
                }
            }

            $response = [
                'success' => true,
                'data' => new QuizDetailResource($course),
                'message' => 'Getting Quiz Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Quiz Found',
            ];
            $status = 404;
        }
        return response()->json($response, $status ??= 200);
    }

    public function getLessonQuizDetails($id)
    {

        $data['quiz'] = new LessonQuizDeatialResource(OnlineQuiz::find($id));

        if ($data['quiz']) {
            $response = [
                'success' => true,
                'data' => $data,
                'message' => 'Getting Quiz Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Quiz Found',
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * Get Top Categories
     *
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "name": "Business",
     * "status": 1,
     * "title": "Voluptas eos placeat",
     * "description": "Laboris Nam laborum voluptatibus dolor aspernatur laboriosam commodo in voluptatem Temporibus eum",
     * "url": "https://youtu.be/bG9eMa_025c",
     * "show_home": 1,
     * "position_order": 2,
     * "image": "public/demo/category/image/1.png",
     * "thumbnail": "public/demo/category/thumb/1.png",
     * "created_at": null,
     * "updated_at": null,
     * "courseCount": 2,
     * "courses": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:19 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * },
     * {
     * "id": 2,
     * "category_id": 1,
     * "subcategory_id": 2,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "An Entire MBA in 1 Course:Award Winning Course",
     * "slug": "an-entire-mba-in-1-courseaward-winning-business-school-prof",
     * "duration": "5H",
     * "image": "public/demo/course/image/2.png",
     * "thumbnail": "public/demo/course/thumb/2.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:19 am",
     * "sumRev": 2,
     * "purchasePrice": 22,
     * "enrollCount": 1
     * }
     * ]
     * },
     * {
     * "id": 2,
     * "name": "3D Modeling",
     * "status": 1,
     * "title": "Voluptas eos placeat",
     * "description": "Laboris Nam laborum voluptatibus dolor aspernatur laboriosam commodo in voluptatem Temporibus eum",
     * "url": "https://youtu.be/bG9eMa_025c",
     * "show_home": 1,
     * "position_order": 2,
     * "image": "public/demo/category/image/2.png",
     * "thumbnail": "public/demo/category/thumb/2.png",
     * "created_at": null,
     * "updated_at": null,
     * "courseCount": 2,
     * "courses": [
     * {
     * "id": 3,
     * "category_id": 2,
     * "subcategory_id": 3,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Complete Blender Creator:3D Modelling for Beginners",
     * "slug": "complete-blender-creator-learn-3d-modelling-for-beginners",
     * "duration": "5H",
     * "image": "public/demo/course/image/3.png",
     * "thumbnail": "public/demo/course/thumb/3.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:19 am",
     * "sumRev": 2,
     * "purchasePrice": 23,
     * "enrollCount": 1
     * },
     * {
     * "id": 4,
     * "category_id": 2,
     * "subcategory_id": 4,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Creating 3D environments in Blender",
     * "slug": "creating-3d-environments-in-blender",
     * "duration": "5H",
     * "image": "public/demo/course/image/4.png",
     * "thumbnail": "public/demo/course/thumb/4.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:20 am",
     * "sumRev": 2,
     * "purchasePrice": 24,
     * "enrollCount": 1
     * }
     * ]
     * },
     * {
     * "id": 3,
     * "name": "UI UX Design",
     * "status": 1,
     * "title": "Voluptas eos placeat",
     * "description": "Laboris Nam laborum voluptatibus dolor aspernatur laboriosam commodo in voluptatem Temporibus eum",
     * "url": "https://youtu.be/bG9eMa_025c",
     * "show_home": 1,
     * "position_order": 3,
     * "image": "public/demo/category/image/3.png",
     * "thumbnail": "public/demo/category/thumb/3.png",
     * "created_at": null,
     * "updated_at": null,
     * "courseCount": 2,
     * "courses": [
     * {
     * "id": 5,
     * "category_id": 3,
     * "subcategory_id": 5,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Adobe XD Design Essentials - UI UX Design",
     * "slug": "creating-3d-environments-in-blender",
     * "duration": "5H",
     * "image": "public/demo/course/image/5.png",
     * "thumbnail": "public/demo/course/thumb/5.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:20 am",
     * "sumRev": 2,
     * "purchasePrice": 25,
     * "enrollCount": 1
     * },
     * {
     * "id": 6,
     * "category_id": 3,
     * "subcategory_id": 6,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "WEB Design: Using HTML & CSS",
     * "slug": "design-rules-principles-practices-for-great-ui-design",
     * "duration": "5H",
     * "image": "public/demo/course/image/6.png",
     * "thumbnail": "public/demo/course/thumb/6.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:20 am",
     * "sumRev": 2,
     * "purchasePrice": 26,
     * "enrollCount": 1
     * }
     * ]
     * },
     * {
     * "id": 4,
     * "name": "Mobile Development",
     * "status": 1,
     * "title": "Voluptas eos placeat",
     * "description": "Laboris Nam laborum voluptatibus dolor aspernatur laboriosam commodo in voluptatem Temporibus eum",
     * "url": "https://youtu.be/bG9eMa_025c",
     * "show_home": 1,
     * "position_order": 4,
     * "image": "public/demo/category/image/4.png",
     * "thumbnail": "public/demo/category/thumb/4.png",
     * "created_at": null,
     * "updated_at": null,
     * "courseCount": 2,
     * "courses": [
     * {
     * "id": 7,
     * "category_id": 4,
     * "subcategory_id": 7,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Introduction to Programming and App Development",
     * "slug": "introduction-to-programming-and-app-development",
     * "duration": "5H",
     * "image": "public/demo/course/image/7.png",
     * "thumbnail": "public/demo/course/thumb/7.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:20 am",
     * "sumRev": 2,
     * "purchasePrice": 27,
     * "enrollCount": 1
     * },
     * {
     * "id": 8,
     * "category_id": 4,
     * "subcategory_id": 8,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "The Complete iOS 11 & Swift Developer Course",
     * "slug": "the-complete-ios-11-swift-developer-course",
     * "duration": "5H",
     * "image": "public/demo/course/image/8.png",
     * "thumbnail": "public/demo/course/thumb/8.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:20 am",
     * "sumRev": 0,
     * "purchasePrice": 0,
     * "enrollCount": 0
     * }
     * ]
     * },
     * {
     * "id": 5,
     * "name": "Software Development",
     * "status": 1,
     * "title": "Voluptas eos placeat",
     * "description": "Laboris Nam laborum voluptatibus dolor aspernatur laboriosam commodo in voluptatem Temporibus eum",
     * "url": "https://youtu.be/bG9eMa_025c",
     * "show_home": 1,
     * "position_order": 5,
     * "image": "public/demo/category/image/5.png",
     * "thumbnail": "public/demo/category/thumb/5.png",
     * "created_at": null,
     * "updated_at": null,
     * "courseCount": 2,
     * "courses": [
     * {
     * "id": 9,
     * "category_id": 5,
     * "subcategory_id": 9,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Complete Python Developer in 2020: Zero to Mastery",
     * "slug": "complete-python-developer-in-2020",
     * "duration": "5H",
     * "image": "public/demo/course/image/8.png",
     * "thumbnail": "public/demo/course/thumb/8.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:20 am",
     * "sumRev": 0,
     * "purchasePrice": 0,
     * "enrollCount": 0
     * },
     * {
     * "id": 10,
     * "category_id": 5,
     * "subcategory_id": 10,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Master Laravel PHP with basic to advanced project",
     * "slug": "master-laravel-php-with-basic-to-advanced-project",
     * "duration": "5H",
     * "image": "public/demo/course/image/9.png",
     * "thumbnail": "public/demo/course/thumb/9.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 11:20 am",
     * "sumRev": 0,
     * "purchasePrice": 0,
     * "enrollCount": 0
     * }
     * ]
     * }
     * ],
     * "message": "Getting Top Categories"
     * }
     */
    public function topCategories()
    {
        $categories = Category::withCount('courses')
            ->orderByDesc('courses_count')
            ->take(10)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => (int) $category->id,
                    'name' => (string) $category->name,
                    'course_count' => (int) $category->courses_count,
                ];
            });

        if ($categories) {
            $response = [
                'success' => true,
                'data' => $categories,
                'message' => 'Getting Top Categories',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Category Found',
            ];
        }

        return response()->json($response, 200);
    }


    /**
     * Get Popular courses
     *
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:40 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * }
     * ],
     * "total": 11,
     * "message": "Getting Courses Data"
     * }
     * @return [json] user object
     */
    public function getPopularCourses()
    {
        $courses = Course::query()
            ->where('type', 1)
            ->where('status',1)
            ->where('scope', 1)
            ->latest('total_enrolled')->take(10)->get();

        return response()->json([
            'success' => true,
            'data' => PopularCoursesResource::collection($courses),
            'message' => 'Getting Courses Data',
        ]);
    }

    public function getPopularQuizes()
    {
        $courses = Course::where('type', '2')->where('status',1)->where('scope', 1)->latest('total_enrolled')->with('courseLevel')->take(10)->get();

        return response()->json([
            'success' => true,
            'data' => PopularCoursesResource::collection($courses),
            'message' => 'Getting Quizzes Data',
        ]);
    }

    public function getPopularClasses()
    {
        $courses = Course::where('type', '3')->where('status',1)->where('scope', 1)->latest('total_enrolled')->with('courseLevel')->take(10)->get();

        return response()->json([
            'success' => true,
            'data' => PopularCoursesResource::collection($courses),
            'message' => 'Getting Classes Data',
        ]);
    }


    /**
     * Get all quizzes
     *
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:40 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * }
     * ],
     * "total": 11,
     * "message": "Getting Courses Data"
     * }
     * @return [json] user object
     */
    public function getPopularQuizzes()
    {
        $courses = Course::where('type', '2')->with('user')->orderBy('total_enrolled', 'desc')->get();

        $response = [
            'success' => true,
            'data' => $courses,
            'total' => count($courses),
            'message' => 'Getting Quiz Data',
        ];
        return response()->json($response, 200);
    }


    /**
     * Search Course
     * @bodyParam  title string required Find course by title.
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:40 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * }
     * ],
     * "total": 11,
     * "message": "Getting Courses Data"
     * }
     *
     */
    public function searchCourse(Request $request)
    {
        $title = $request->get('title');
        $courses = Course::where('title', 'like', '%' . $title . '%')->with('user')->get();
        if ($courses) {
            $response = [
                'success' => true,
                'data' => $courses,
                'total' => count($courses),
                'message' => 'Getting Courses Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Course Found',
            ];
        }

        return response()->json($response, 200);
    }


    /**
     * Search Quiz
     * @bodyParam  title string required Find quiz by title.
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:40 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * }
     * ],
     * "total": 11,
     * "message": "Getting Quiz Data"
     * }
     */
    public function searchQuiz(Request $request)
    {
        $title = $request->get('title');
        $courses = Course::where('title', 'like', '%' . $title . '%')->with('user')->get();
        if ($courses) {
            $response = [
                'success' => true,
                'data' => $courses,
                'total' => count($courses),
                'message' => 'Getting Quiz Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Quiz Found',
            ];
        }


        return response()->json($response, 200);
    }


    /**
     * Filter Course
     * @bodyParam  category number Find course by category.
     * @bodyParam  sub_category number required Find course by sub category.
     * @bodyParam  level number  Find course by level.
     * @bodyParam  language number required Find course by language.
     * @bodyParam  min_price number  Find course by min price.
     * @bodyParam  max_price number  Find course by max price.
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:40 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * }
     * ],
     * "total": 11,
     * "message": "Getting Courses Data"
     * }
     *
     */
    public function filterCourse(Request $request)
    {
        $category = $request->get('category');
        $sub_category = $request->get('sub_category');
        $level = $request->get('level');
        $language = $request->get('language');
        $price = $request->get('price');
        $query = Course::where('status', 1)->where('scope',1)->with('user')->where('type', 1);

        if (!empty($category)) {
            $query->where('category_id', $category);
        }
        if (!empty($sub_category)) {
            $query->where('subcategory_id', $sub_category);
        }

        if (!empty($level)) {
            $query->where('level', $level);
        }

        if (!empty($language)) {
            $query->where('lang_id', $language);
        }

        if (!empty($price)) {
            if ($price == "Free") {
                $query->where('price', '=', 0);
            } else {
                $query->where('price', '!=', 0);
            }
        }


        $courses = $query->get();
//
        if ($courses) {
            $response = [
                'success' => true,
                'data' => CoursesResource::collection($courses),
                'total' => count($courses),
                'message' => 'Getting Courses Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Course Found',
            ];
        }

        return response()->json($response, 200);
    }

    /**
     * Filter Quiz
     * @bodyParam  category number Find course by category.
     * @bodyParam  sub_category number required Find course by sub category.
     * @bodyParam  level number  Find course by level.
     * @bodyParam  language number required Find course by language.
     * @bodyParam  min_price number  Find course by min price.
     * @bodyParam  max_price number  Find course by max price.
     * @response
     * {
     * "success": true,
     * "data": [
     * {
     * "id": 1,
     * "category_id": 1,
     * "subcategory_id": 1,
     * "quiz_id": null,
     * "user_id": 2,
     * "lang_id": 1,
     * "title": "Managerial Accounting Advance Course",
     * "slug": "managerial-accounting",
     * "duration": "5H",
     * "image": "public/demo/course/image/1.png",
     * "thumbnail": "public/demo/course/thumb/1.png",
     * "price": 20,
     * "discount_price": 10,
     * "publish": 1,
     * "status": 1,
     * "level": 2,
     * "trailer_link": "https://www.youtube.com/watch?v=mlqWUqVZrHA",
     * "host": "Youtube",
     * "meta_keywords": null,
     * "meta_description": null,
     * "about": "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text\r\n            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book",
     * "special_commission": null,
     * "total_enrolled": 1,
     * "reveune": 50,
     * "reveiw": 0,
     * "type": 1,
     * "created_at": null,
     * "updated_at": null,
     * "dateFormat": "17th November 2020",
     * "publishedDate": "17th November 2020 10:40 am",
     * "sumRev": 2,
     * "purchasePrice": 21,
     * "enrollCount": 1
     * }
     * ],
     * "total": 11,
     * "message": "Getting Courses Data"
     * }
     *
     */
    public function filterQuiz(Request $request)
    {
        $category = $request->get('category');
        $sub_category = $request->get('sub_category');
        $level = $request->get('level');
        $language = $request->get('language');
        $min_price = $request->get('min_price');
        $max_price = $request->get('max_price');
        $query = Course::where('status', 1)->where('type', 2);

        if (!empty($category)) {
            $query->where('category_id', $category);
        }
        if (!empty($sub_category)) {
            $query->where('subcategory_id', $sub_category);
        }

        if (!empty($level)) {
            $query->where('subcategory_id', $level);
        }

        if (!empty($language)) {
            $query->where('lang_id  ', $language);
        }
        if (!empty($min_price)) {
            $query->where('price  ', '<=', $min_price);
        }
        if (!empty($min_price)) {
            $query->where('price  ', '>=', $max_price);
        }
        $courses = $query->get();
        if ($courses) {
            $response = [
                'success' => true,
                'data' => $courses,
                'total' => count($courses),
                'message' => 'Getting Quiz Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Quiz Found',
            ];
        }

        return response()->json($response, 200);
    }

    public function categories()
    {
        $categories = Category::where('status', 1)
            ->whereNull('parent_id')
            ->orderBy('position_order', 'ASC')
            ->get()->map(function ($category) {
                return [
                    'id' => (int)$category->id,
                    'name' => (string)$category->name,
                ];
            });
        if ($categories) {
            $response = [
                'success' => true,
                'data' => $categories,
                'message' => 'Getting Category Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Category Found',
            ];
            $status = 404;
        }

        return response()->json($response, $status ??= 200);
    }

    public function categoryCourses(Request $request)
    {
        // $categories = Category::where('status', 1)->select('id', 'name')->get();


        $categoryId = $request->category_id;
        $search = $request->search;

        $query = Course::where('required_type', 0)
            ->orderBy('updated_at', 'desc')
            ->where('status', 1)
            ->where('type', 1);
        if (!empty($search)) {
            if (!empty($categoryId)) {
                $query->where('category_id', $categoryId)->where('title', 'LIKE', "%{$search}%");
            } else {
                $query->where('title', 'LIKE', "%{$search}%");
            }
        }
        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        $open_courses = $query->get();

        $data = collect();

        foreach ($open_courses as $course) {

            $c = [
                'course_id' => $course->id,
                'category_id' => $course->category_id,
                'thumbnail' => getCourseImage($course->thumbnail),
                'title' => $course->title,
                'user_name' => $course->user->name,
                'lessons' => count($course->lessons),
                'category_name' => $course->category->name,
                'mode' => $course->mode_of_delivery,
                'isEnrolledCourse' => $course->isLoginUserEnrolled,
            ];

            $data->push($c);
        }

        $response = [
            'success' => true,
            'data' => $data->all(),
            'total' => count($open_courses),
            'message' => 'Getting Category Courses Data',
        ];

        return response()->json($response, 200);
    }

    public function buyNow(Request $request)
    {
        try {
            $user = auth('api')->user();

            $course = Course::find($request->id);

            if ($course->price == 0) {
                $enroll = new CourseEnrolled();
                $enroll->user_id = auth('api')->user()->id;
                $enroll->tracking = 1;
                $enroll->course_id = $request->id;
                $enroll->purchase_price = 0;
                $enroll->coupon = null;
                $enroll->discount_amount = 0;
                $enroll->status = 1;
                $enroll->save();

                $course->total_enrolled = $course->total_enrolled + 1;
                $course->save();

                if (isModuleActive('Chat')) {
                    event(new OneToOneConnection($course->user, $user, $course));
                }
                if (isModuleActive('Survey')) {
                    $hasSurvey = Survey::where('course_id', $course->id)->get();
                    foreach ($hasSurvey as $survey) {
                        $surveyController = new SurveyController();
                        $surveyController->assignSurvey($survey, $user);
                    }
                }
                if (isModuleActive('Affiliate')) {
                    if ($user->isReferralUser) {
                        Event::dispatch(new ReferralPayment($user->id, $course->id, $course->discount_price ?: $course->price));
                    }
                }
                $response = [
                    'success' => true,
                    'message' => trans('org.Enrolled Successfully'),
                ];

                return response()->json($response, 200);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Course isn\'t free.',
                ];
                return response()->json($response, 200);
            }
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function subCategories($category_id)
    {
        $categories = Category::where('parent_id', $category_id)->where('status', 1)->select('id', 'name')->get();
        if ($categories) {
            $response = [
                'success' => true,
                'data' => $categories,
                'total' => count($categories),
                'message' => 'Getting Sub Category Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Sub Category Found',
            ];
        }
        return response()->json($response, 200);
    }

    public function levels()
    {
        $levels = CourseLevel::where('status', 1)
            ->get()->map(function ($level) {
                return [
                    'id' => (int)$level->id,
                    'title' => (string)$level->title,
                ];
            });
        if ($levels) {
            $response = [
                'success' => true,
                'data' => $levels,
                'message' => 'Getting Level Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Level Found',
            ];
            $status = 404;
        }
        return response()->json($response, $status ??= 200);
    }


    public function languages()
    {
        $languages = Language::where('status', 1)->select('id', 'code', 'name', 'native', 'rtl')->get();
        if ($languages) {
            $response = [
                'success' => true,
                'data' => $languages,
                'total' => count($languages),
                'message' => 'Getting Language Data',
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'No Language Found',
            ];
            $status = 404;
        }
        return response()->json($response, $status ??= 200);
    }


    public function getCertificate($id, Request $request)
    {

        try {

            $websiteApiController = new WebsiteApiController();
            $websiteApiController->getCertificateRecord($id);

            $certificate = CertificateRecord::where('student_id', auth('api')->user()->id)->where('course_id', $id)->first();

            $certificate->title = @$certificate->course->title;

            earnCourseBadge($certificate->course_id, auth('api')->id(), $certificate->course->has_badge);

            $certificate->start_date = showDate($certificate->start_date);
            $certificate->end_date = empty($certificate->end_date) ? trans('org.Limitless') : showDate($certificate->end_date);

            $certificate->image = asset('public/certificate/' . $certificate->id . '.jpg');

            return [
                'success' => true,
                'data' => $certificate,
                'message' => "Operation successful"
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'message' => "Operation failed"
            ];
        }
    }

    public function getCourseFromSlug(Request $request)
    {
        $course = Course::where('slug', $request->slug)->first();

        return $course->id;
    }

    public function getLessonCompleteStatus($course_id,$lesson_id)
    {
        try {
            $course =Course::with(['chapters','lessons','lessons.completed'])->find($course_id);
            $all=$course->lessons->sortBy('position');
            $lesson_ids = [];

            foreach ($course->chapters as $c) {
                foreach ($all as $item) {
                    if ($c->id == $item->chapter_id) {
                        $lesson_ids[] = $item->id;

                    }
                }
            }

            $index = array_search($lesson_id, $lesson_ids);

            $previous = $lesson_ids[$index - 1] ?? null;


            if ($previous) {
                $isComplete = DB::table('lesson_completes')->where(function ($q) use($lesson_id,$previous){
                    $q->where('lesson_id', $previous)->orWhere('lesson_id', $lesson_id);
                })->where('user_id', Auth::id())->select('status')->first();

                if (!$isComplete || $isComplete->status != 1) {
                     return [
                        'success'=>false,
                        'message'=>trans('frontend.At First, You need to complete previous lesson')
                    ];
                }
            }

            return [
                'success'=>true,
                'message'=>'Allow to continue'
            ];
        }catch (Exception $exception){
            return [
                'success'=>false,
                'message' =>trans('backup::common.Something Went Wrong'),
            ];
        }
    }
}
