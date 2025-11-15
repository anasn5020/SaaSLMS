<?php

namespace Modules\StudentSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\GoogleAnalytics4;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\StudentSetting\Entities\BookmarkCourse;


class BookmarkController extends Controller
{
    use GoogleAnalytics4;

    public function bookmarkSave($id)
    {
        try {
            $bookmarked = BookmarkCourse::where('user_id', Auth::id())->where('course_id', $id)->first();
            if (empty($bookmarked)) {
                $bookmark = new BookmarkCourse;
                $bookmark->user_id = Auth::id();
                $bookmark->course_id = $id;
                $bookmark->date = date("jS F Y");
                $bookmark->save();

                $this->postEvent([
                    'name' => 'add_to_wishlist',
                    'params' => [
                        "items" => [
                            [
                                "item_id" => $id,
                                "item_name" => $bookmark->course?->title,
                            ]
                        ],
                    ],
                ]);

                Toastr::success(trans('frontend.Wishlist Added Successfully'), trans('common.Success'));
            } else {

                $this->postEvent([
                    'name' => 'remove_from_wishlist',
                    'params' => [
                        "items" => [
                            [
                                "item_id" => $id,
                                "item_name" => $bookmarked->course?->title,
                            ]
                        ],
                    ],
                ]);
                $bookmarked->delete();
                Toastr::success(trans('frontend.Wishlist Remove Successfully'), trans('common.Success'));

            }

            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

}
