<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\GoogleAnalytics4;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\BBB\Entities\BbbMeeting;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\GoogleMeet\Entities\GoogleMeetMeeting;
use Modules\InAppLiveClass\Entities\InAppLiveClassMeeting;
use Modules\Jitsi\Entities\JitsiMeeting;
use Modules\VirtualClass\Entities\ClassComplete;
use Modules\VirtualClass\Entities\CustomMeeting;
use Modules\Zoom\Entities\ZoomMeeting;

class ClassController extends Controller
{
    use GoogleAnalytics4;

    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);
    }

    public function classes(Request $request)
    {
        try {
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/classes')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                return view(theme('pages.classes'), compact('request'));
            }

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function classDetails($slug, Request $request)
    {

        try {


            $course = Course::with('user', 'enrolls', 'reviews', 'comments', 'virtualClass', 'activeReviews', 'enrollUsers')->where('slug', $slug)->first();
            if (!$course) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
            $this->postEvent([
                'name' => 'view_item',
                'params' => [
                    "items" => [
                        [
                            "item_id" => $course->id,
                            "item_name" => $course->title,
                            'type' => 'class',
                            "price" => !empty($course->discount_price) ? $course->discount_price : $course->price,
                        ]
                    ],
                ],
            ]);
            if (!isViewable($course)) {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->to(route('classes'));
            }

            if (Auth::check()) {
                $isEnrolled = $course->isLoginUserEnrolled;
            } else {
                $isEnrolled = false;
            }
            $comments = CourseComment::where('course_id', $course->id)->with('replies', 'replies.user', 'user')
                ->where('status', 1)
                ->get();

            $data = '';
            if ($request->ajax()) {
                if ($request->type == "comment") {
                    foreach ($comments as $comment) {
                        $data .= view(theme('partials._single_comment'), ['comment' => $comment, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();
                    }
                    return $data;
                }

            }
            $reviews = DB::table('course_reveiws')
                ->select(
                    'course_reveiws.id',
                    'course_reveiws.star',
                    'course_reveiws.comment',
                    'course_reveiws.instructor_id',
                    'course_reveiws.created_at',
                    'users.id as userId',
                    'users.name as userName',
                )
                ->join('users', 'users.id', '=', 'course_reveiws.user_id')
                ->where('course_reveiws.status',1)
                ->where('course_reveiws.course_id', $course->id)->get();

            $data = '';
            if ($request->ajax()) {
                if ($request->type == "review") {
                    foreach ($reviews as $review) {
                        $data .= view(theme('partials._single_review'), ['review' => $review, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();
                    }
                    if (count($reviews) == 0) {
                        $data .= '';
                    }
                    return $data;
                }
            }
            $course->view = $course->view + 1;
            $course->save();
            return view(theme('pages.class_details'), compact('request', 'course'));

        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function classStart($slug, $host, $meeting_id)
    {
        if (isModuleActive('Subscription')) {
            if (!isSubscriptionExpire()) {
                Toastr::error(trans('frontend.Your subscription validity expired'),trans('common.Failed'));
                return redirect()->back();
            }
        }
        try {

            $course = Course::with('user', 'enrolls', 'reviews', 'comments', 'virtualClass', 'activeReviews', 'enrollUsers')->where('slug', $slug)->first();
            if (!$course) {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }

            if (!isViewable($course)) {
                Toastr::error(trans('common.Access Denied'), trans('common.Failed'));
                return redirect()->to(route('classes'));
            }


            if (!Auth::check()) {
                Toastr::error(trans('frontend.You are not enrolled for this course'), trans('common.Failed'));
                return redirect()->back();
            } else {
                if (!$course->isLoginUserEnrolled) {
                    Toastr::error(trans('frontend.You are not enrolled for this course'), trans('common.Failed'));
                    return redirect()->back();
                }
            }

            $classComplete = ClassComplete::where('course_id', $course->id)
                ->where('class_id', $course->class_id)
                ->where('host', $host)
                ->where('meeting_id', $meeting_id)
                ->where('user_id', Auth::user()->id)
                ->first();
            if (!$classComplete) {
                $classComplete = new ClassComplete();
                $classComplete->course_id = $course->id;
                $classComplete->class_id = $course->class_id;
                $classComplete->host = $host;
                $classComplete->meeting_id = $meeting_id;
                $classComplete->user_id = Auth::user()->id;
                $classComplete->status = 1;
            }
            $classComplete->save();


            $websiteController = new WebsiteController();
            $websiteController->getCertificateRecord($course->id);

            if ($host == "Zoom") {
                $meeting = ZoomMeeting::find($meeting_id);
                if ($meeting) {
                    return redirect(route('zoom.meeting.join', $meeting->meeting_id));
                }
            } elseif ($host == "BBB") {
                $meeting = BbbMeeting::find($meeting_id);
                if ($meeting) {
                    return redirect(url('bbb/meeting-start-attendee/' . $course->id . '/' . $meeting->meeting_id));
                }
            } elseif ($host == "Jitsi") {
                $meeting = JitsiMeeting::find($meeting_id);
                if ($meeting) {
                    return redirect(url('jitsi/meeting-start/' . $course->id . '/' . $meeting->meeting_id));
                }
            } elseif ($host == "InAppLiveClass") {
                $meeting = InAppLiveClassMeeting::find($meeting_id);
                if ($meeting) {
                    return redirect(route('inappliveclass.meetings.show', $meeting_id));
                }
            } elseif ($host == "Custom") {
                $meeting = CustomMeeting::find($meeting_id);
                if ($meeting) {
                    return redirect(route('custom.meetings.show', $meeting_id));
                }
            } elseif ($host == "GoogleMeet") {
                $meeting = GoogleMeetMeeting::find($meeting_id);
                if ($meeting) {
                    return redirect(url($meeting->hangoutLink));
                }
            }

            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
