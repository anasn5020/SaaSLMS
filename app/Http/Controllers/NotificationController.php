<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\CourseSetting\Entities\Notification;
use Modules\Noticeboard\Entities\Noticeboard;

class NotificationController extends Controller
{
    public function ajaxNotificationMakeRead(Request $request)
    {
        $url = '';
        if (Auth::check()) {
            $notification = Auth::user()->unreadNotifications->find($request->id);

            if ($notification) {
                $url = $notification->data['actionURL'] ?? '';
                $notification->markAsRead();
            }
        }


        return json_encode($url);
    }

    public function NotificationMakeAllRead(Request $request)
    {

        if (!Auth::check()) {
            return redirect('login');
        }
        try {
            Auth::user()->unreadNotifications->markAsRead();
            Toastr::success(trans('frontend.All Notification Marked As Read'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function myNotificationSetup()
    {
        return view(theme('pages.myNotificationsSetup'));
    }

    public function myNotification(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        try {
            return view(theme('pages.myNotifications'), compact('request'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function myNoticeboard(Request $request)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        try {
            return view(theme('pages.myNoticeboard'), compact('request'));
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
            return view(theme('partials._noticeboard_modal'), compact('noticeboard', 'courseIds'));
        } catch (\Exception $e) {
            return response([], 404);
        }
    }

    public function delete($id)
    {
        try {
            Notification::where('id', $id)->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $exception) {
            GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function getNotificationUpdate()
    {
        $user = Auth::user();
        $data['total'] = $user->unreadNotifications->count();
        $notifications = $user->unreadNotifications;
        if ($user->role_id == 3) {
            $data['notification_body'] = view(theme('partials._notification'), compact('notifications'))->render();
        } else {
            $data['notification_body'] = view('backend.partials._notification', compact('notifications'))->render();
        }
        return $data;
    }

}
