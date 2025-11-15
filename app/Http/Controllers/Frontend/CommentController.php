<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Traits\SendNotification;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseComment;
use Modules\CourseSetting\Entities\CourseCommentReply;
use Modules\CourseSetting\Entities\CourseReveiw;

class CommentController extends Controller
{
    use SendNotification;

    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);
    }


    public function saveComment(Request $request)
    {
        Session::flash('selected_tab', 'qa');
        $request->validate([
            'course_id' => 'required',
            'comment' => 'required',
        ]);


        try {
            $course = Course::where('id', $request->course_id)->first();

            if (isset($course)) {
                $comment = new CourseComment();
                $comment->user_id = Auth::user()->id;
                $comment->course_id = $request->course_id;
                $comment->instructor_id = $course->user_id;
                $comment->comment = $request->comment;
                $comment->status = (int) Settings('topic_comment_auto_approval');
                $comment->save();


                $this->sendNotification('Course_comment', $course->user, [
                    'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                    'course' => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                    'comment' => $comment->comment,
                ], [
                    'actionText' => trans('common.View'),
                    'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                ]);

                if (isModuleActive('Org')) {
                    addOrgRecentActivity(\auth()->id(), $course->id, 'Comment');
                }

                checkGamification('each_comment', 'communication');

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('frontend.Invalid access'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function saveCommentAjax(Request $request)
    {

        try {
            $course = Course::where('id', $request->course_id)->first();

            if (isset($course)) {
                $comment = new CourseComment();
                $comment->user_id = Auth::user()->id;
                $comment->course_id = $request->course_id;
                $comment->instructor_id = $course->user_id;
                $comment->comment = $request->comment;
                $comment->status = (int) Settings('topic_comment_auto_approval');
                $comment->save();


                $this->sendNotification('Course_comment', $course->user, [
                    'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                    'course' => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                    'comment' => $comment->comment,
                ], [
                    'actionText' => trans('common.View'),
                    'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                ]);


                if (isModuleActive('Org')) {
                    addOrgRecentActivity(\auth()->id(), $course->id, 'Comment');
                    if (richTextWordLength($request->comment) >= 20) {
                        orgLeaderboardPointCheck('Interaction', Settings('question_qa'), $comment->course_id, 'question');
                    }
                }
                checkGamification('each_comment', 'communication');

                $isEnrolled = $course->isLoginUserEnrolled;
                return view(theme('partials._single_comment'), ['comment' => $comment, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();

            }
        } catch (\Exception $e) {

        }

        return '';
    }

    public function submitCommnetReply(Request $request)
    {
        Session::flash('selected_tab', 'qa');
        $request->validate([
            'comment_id' => 'required',
            'reply' => 'required'
        ]);
        try {
            $comment = CourseComment::find($request->comment_id);
            $course = $comment->course;
            $commentUser = $comment->user;

            if (isset($course)) {
                $comment = new CourseCommentReply();
                $comment->user_id = Auth::user()->id;
                $comment->course_id = $course->id;
                if (!empty($request->reply_id)) {
                    $comment->reply_id = $request->reply_id;
                } else {
                    $comment->reply_id = null;
                }
                $comment->comment_id = $request->comment_id;
                $comment->reply = $request->reply;
                $comment->status = (int) Settings('topic_comment_auto_approval');
                $comment->save();

                if ($course->user->id != Auth::user()->id) {

                    $this->sendNotification('Course_comment_Reply', $course->user, [
                        'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                        'course' => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                        'comment' => $comment->comment,
                        'reply' => $comment->reply,
                    ], [
                        'actionText' => trans('common.View'),
                        'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    ]);

                }

                $this->sendNotification('Course_comment_Reply', $commentUser, [
                    'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                    'course' => $course->getTranslation('title', $commentUser->language_code ?? config('app.fallback_locale')),
                    'comment' => $comment->comment,
                    'reply' => $comment->reply,
                ], [
                    'actionText' => trans('common.View'),
                    'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                ]);

                checkGamification('each_comment', 'communication');


                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
            } else {
                Toastr::error(trans('frontend.Invalid access'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function submitCommnetReplyAjax(Request $request)
    {
        try {
            $comment = CourseComment::find($request->comment_id);
            $course = $comment->course;
            $commentUser = $comment->user;

            if (isset($course)) {
                $comment = new CourseCommentReply();
                $comment->user_id = Auth::user()->id;
                $comment->course_id = $course->id;
                if (!empty($request->reply_id)) {
                    $comment->reply_id = $request->reply_id;
                } else {
                    $comment->reply_id = null;
                }
                $comment->comment_id = $request->comment_id;
                $comment->reply = $request->reply;
                $comment->status = (int) Settings('topic_comment_auto_approval');
                $comment->save();

                if ($course->user->id != Auth::id()) {

                    $this->sendNotification('Course_comment_Reply', $course->user, [
                        'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                        'course' => $course->getTranslation('title', $course->user->language_code ?? config('app.fallback_locale')),
                        'comment' => $comment->comment,
                        'reply' => $comment->reply,
                    ], [
                        'actionText' => trans('common.View'),
                        'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    ]);

                }

                $this->sendNotification('Course_comment_Reply', $commentUser, [
                    'time' => Carbon::now()->translatedFormat('d-M-Y, g:i A'),
                    'course' => $course->getTranslation('title', $commentUser->language_code ?? config('app.fallback_locale')),
                    'comment' => $comment->comment,
                    'reply' => $comment->reply,
                ], [
                    'actionText' => trans('common.View'),
                    'actionUrl' => courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                ]);

                $isEnrolled = $course->isLoginUserEnrolled;
                checkGamification('each_comment', 'communication');

                if (richTextWordLength($request->reply) >= 20) {
                    orgLeaderboardPointCheck('Interaction', Settings('answer_qa'), $comment->course_id, 'answer');
                }

                return view(theme('partials._single_comment_reply'), ['replay' => $comment, 'isEnrolled' => $isEnrolled, 'course' => $course])->render();

            }
        } catch (\Exception $e) {
        }
        return "";
    }


    public function deleteComment($id)
    {
        try {
            $comment = CourseComment::find($id);
            $user = Auth::user();
            if ($comment->user_id == $user->id || $user->role_id == 1 || $comment->instructor_id == $user->id) {
                $comment->delete();
                if (isset($comment->replies)) {
                    foreach ($comment->replies as $replay) {
                        $replay->delete();
                    }
                }
                return true;
            } else {
                return false;
            }


        } catch (\Exception $exception) {
            return false;

        }
    }

    public function deleteReview($id)
    {
        try {
            $review = CourseReveiw::find($id);
            $course_id = $review->course_id;
            $user = Auth::user();
            if ($review->user_id == $user->id || $user->role_id == 1 || $review->instructor_id == $user->id) {
                $review->delete();

                $course = Course::find($course_id);
                $total = CourseReveiw::where('course_id', $course->id)->sum('star');
                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
                if ($total != 0) {
                    $average = $count > 0 ? $total / $count : 0;
                } else {
                    $average = 0;
                }
                $course->reveiw = $average;
                $course->total_rating = $average;
                $course->save();


                $course_user = User::find($course->user_id);
                $user_courses = Course::where('user_id', $course_user->id)->get();
                $user_total = 0;
                $user_rating = 0;
                foreach ($user_courses as $u_course) {
                    $total = CourseReveiw::where('course_id', $u_course->id)->sum('star');
                    $count = CourseReveiw::where('course_id', $u_course->id)->where('status', 1)->count();
                    if ($total != 0) {
                        $user_total = $user_total + 1;
                        $average = $count > 0 ? $total / $count : 0;
                        $user_rating = $user_rating + $average;
                    }
                }
                if ($user_total != 0) {
                    $user_rating = $user_rating / $user_total;
                }
                $course_user->total_rating = $user_rating;
                $course_user->save();

                $total = CourseReveiw::where('course_id', $course->id)->sum('star');
                $count = CourseReveiw::where('course_id', $course->id)->where('status', 1)->count();
                if ($total != 0) {
                    $average = $count > 0 ? $total / $count : 0;
                } else {
                    $average = 0;
                }
                $course->reveiw = $average;
                $course->total_rating = $average;
                $course->save();


                return true;
            } else {
                return false;
            }


        } catch (\Exception $exception) {
            return false;
        }
    }

    public function deleteCommnetReply($id)
    {
        try {

            $reply = CourseCommentReply::find($id);
            $course = Course::find($reply->course_id);
            $user = Auth::user();

            if ($reply->user_id == $user->id || $user->role_id == 1 || $course->user_id == $user->id) {
                $reply->delete();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            } else {
                Toastr::error(trans('frontend.Invalid access'), trans('common.Failed'));
            }
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function getCommentsReply(Request $request)
    {
        $data = '';
        $comments = CourseComment::where('course_id', $request->course_id)->withCount('replies')->orderByDesc("replies_count")->orderBy('id', 'DESC')->with('replies', 'replies.user', 'user')->paginate(10);
        foreach ($comments as $comment) {
            $data .= view(theme('partials._single_comment'), ['comment' => $comment])->render();
        }
        return $data;
    }

}
