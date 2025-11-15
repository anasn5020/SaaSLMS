<?php

namespace Modules\Setting\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\Setting\Entities\UserGamificationPoint;
use Modules\StudentSetting\Entities\Institute;
use Yajra\DataTables\Facades\DataTables;

class GamificationHistoryController extends Controller
{
    public function index()
    {
        $courses =Course::select('id', 'title')->where('status', 1)->get();
        $levels =CourseLevel::select('id', 'title')->where('status', 1)->get();
        $institutes =Institute::where('status', 1)->select('id', 'name')->get();
        return view('setting::gamification.history',compact('levels','institutes','courses'));
    }

    public function data(Request $request)
    {

        $query = User::select('id', 'name', 'image', 'email', 'gamification_total_points', 'gamification_total_spent_points')
            ->when(\request()->get('institute'), function ($q) {
                $q->where('institute_id', \request()->get('institute'));
            })
            ->when(\request()->get('level'), function ($q) {
                $q->whereHas('studentCourses', function ($q) {
                    $q->whereHas('course', function ($q) {
                        $q->where('level', \request()->get('level'));
                    });
                });
            })
            ->when(\request()->get('course'), function ($q) {
                $q->whereHas('studentCourses', function ($q) {
                    $q->where('course_id', \request()->get('course'));
                });
            })
            ->where('role_id', '!=', 1);


        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getProfileImage($query->image, $query->name) . "'   alt='" . $query->name . " image'></div>";
            })->editColumn('name', function ($query) {
                return $query->name;

            })->editColumn('email', function ($query) {
                return $query->email;

            })
            ->editColumn('gamification_total_points', function ($query) {
                return translatedNumber($query->gamification_total_points);

            })
            ->editColumn('gamification_total_spent_points', function ($query) {
                return translatedNumber($query->gamification_total_spent_points);

            })
            ->addColumn('gamification_total_remain_points', function ($query) {
                return translatedNumber($query->gamification_total_points - $query->gamification_total_spent_points);
            })
            ->addColumn('action', function ($query) {


                $details = '<button class="dropdown-item detailsHistory"
                                                                    data-id="' . $query->id . '"
                                                                    data-type="1"
                                                                    data-title="' . trans('setting.Earn History') . '"
                                                                    type="button">' . trans('setting.Earn History') . '</button>';
                $details .= '<button class="dropdown-item detailsHistory"
                                                                    data-id="' . $query->id . '"
                                                                      data-type="2"
                                                                    data-title="' . trans('setting.Spent History') . '"
                                                                    type="button">' . trans('setting.Spent History') . '</button>';


                return ' <div class="dropdown CRM_dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenu' . $query->id . '" data-bs-toggle="dropdown"
                                                            aria-haspopup="true"
                                                            aria-expanded="false">
                                                        ' . trans('common.Action') . '
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                         aria-labelledby="dropdownMenu' . $query->id . '">
                                                        ' . $details . '
                                                    </div>
                                                </div>';


            })->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function history_details($type, $id)
    {
        $details = UserGamificationPoint::where('status', $type)->where('point', '!=', 0)->where('user_id', $id)->get();
        return view('setting::gamification._modal_history', compact('details'));
    }

}
