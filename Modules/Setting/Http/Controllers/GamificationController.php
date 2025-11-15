<?php

namespace Modules\Setting\Http\Controllers;

use App\LessonComplete;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\Setting\Entities\Badge;
use Modules\Setting\Entities\UserBadge;
use Modules\Setting\Entities\UserGamificationPoint;
use Modules\Setting\Entities\UserLevelHistory;

class GamificationController extends Controller
{
    public function index()
    {
        $badges = Badge::select('point', 'type')->where('status', 1)->orderBy('point')->get();

        $data['activity'] = $badges->where('type', 'activity');
        $data['registration'] = $badges->where('type', 'registration');
        $data['learning'] = $badges->where('type', 'learning');
        $data['courses'] = $badges->where('type', 'courses');
        $data['rating'] = $badges->where('type', 'rating');
        $data['sales'] = $badges->where('type', 'sales');
        $data['blogs'] = $badges->where('type', 'blogs');
        $data['test'] = $badges->where('type', 'test');
        $data['assignment'] = $badges->where('type', 'assignment');
        $data['perfectionism'] = $badges->where('type', 'assignment');
        $data['survey'] = $badges->where('type', 'survey');
        $data['communication'] = $badges->where('type', 'communication');
        $data['certification'] = $badges->where('type', 'certification');

        return view('setting::gamification.index', $data);
    }

    public function reset()
    {
        $settings = [
            'gamification_status' => 1,

            'gamification_point_status' => 1,

            'gamification_point_each_login_status' => 1,
            'gamification_point_each_login_point' => 1,

            'gamification_point_each_unit_complete_status' => 1,
            'gamification_point_each_unit_complete_point' => 5,

            'gamification_point_each_course_complete_status' => 1,
            'gamification_point_each_course_complete_point' => 25,

            'gamification_point_each_certificate_status' => 1,
            'gamification_point_each_certificate_point' => 25,

            'gamification_point_each_test_complete_status' => 1,
            'gamification_point_each_test_complete_point' => 5,

            'gamification_point_each_assignment_complete_status' => 1,
            'gamification_point_each_assignment_complete_point' => 5,

            'gamification_point_each_comment_status' => 1,
            'gamification_point_each_comment_point' => 1,


            'gamification_badges_status' => 1,

            'gamification_badges_activity_status' => 1,
            'gamification_badges_registration_status' => 1,
            'gamification_badges_courses_status' => 1,
            'gamification_badges_rating_status' => 1,
            'gamification_badges_sales_status' => 1,
            'gamification_badges_blogs_status' => 1,
            'gamification_badges_learning_status' => 1,
            'gamification_badges_test_status' => 1,
            'gamification_badges_assignment_status' => 1,
            'gamification_badges_perfectionism_status' => 1,
            'gamification_badges_survey_status' => 1,
            'gamification_badges_communication_status' => 1,
            'gamification_badges_certification_status' => 1,

            'gamification_reward_point_conversion_rate' => 500,

            'gamification_level_status' => 1,

            'gamification_level_entry_point_status' => 1,
            'gamification_level_entry_point' => 3000,

            'gamification_level_entry_complete_status' => 1,
            'gamification_level_entry_complete_point' => 5,

            'gamification_level_entry_badge_status' => 1,
            'gamification_level_entry_badge_point' => 5,


            'gamification_reward_status' => 0,

            'gamification_reward_discount_course_point_status' => 0,
            'gamification_reward_discount_course_point' => '',
            'gamification_reward_course_point' => 1000,

            'gamification_reward_discount_course_badge_status' => 0,
            'gamification_reward_discount_course_badge' => 10,
            'gamification_reward_course_badge' => 50,

            'gamification_reward_discount_course_level_status' => 0,
            'gamification_reward_discount_course_level' => 10,
            'gamification_reward_course_level' => 25,


            'gamification_leaderboard_status' => 1,
            'gamification_leaderboard_show_level_status' => 1,
            'gamification_leaderboard_show_point_status' => 1,
            'gamification_leaderboard_show_badges_status' => 1,
            'gamification_leaderboard_show_courses_status' => 0,
            'gamification_leaderboard_show_certificate_status' => 0,


            'gamification_leaderboard_filter_status'=>0,
            'gamification_leaderboard_filter_course_level_status'=>0,
            'gamification_leaderboard_filter_class_status'=>0,
            'gamification_leaderboard_filter_institute_status'=>0,
        ];
        foreach ($settings as $key => $setting) {
            UpdateGeneralSetting($key, $setting);
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function statisticReset(Request $request)
    {
        $query = User::query();
        if ($request->get('user')) {
            $query->where('id', $request->get('user'));
        } else {
            $query->where('status', 1)
                ->where('role_id', 3)
                ->where('teach_via', 1);
        }
        $user_ids = $query->pluck('id')->toArray();


        if ($request->type == 'point' || empty($request->type)) {
            User::whereIn('id', $user_ids)
                ->update([
                    'gamification_points' => 0,
                    'gamification_total_points' => 0,
                    'gamification_total_spent_points' => 0,
                ]);
            UserGamificationPoint::whereIn('user_id', $user_ids)->delete();
            LessonComplete::whereIn('user_id', $user_ids)->delete();
            CertificateRecord::whereIn('student_id', $user_ids)->delete();
        }

        if ($request->type == 'badges' || empty($request->type)) {
            User::whereIn('id', $user_ids)
                ->update([
                    'gamification_points' => 0,
                    'gamification_total_points' => 0,
                    'gamification_total_spent_points' => 0,
                ]);
            UserBadge::whereIn('user_id', $user_ids)->delete();
        }

        if ($request->type == 'level' || empty($request->type)) {
            User::whereIn('id', $user_ids)
                ->update([
                    'user_level' => 1,
                ]);

            UserLevelHistory::whereIn('user_id', $user_ids)->delete();
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();

    }

    public function update(Request $request)
    {
        $g_status = $request->get('gamification_status', 0);
        UpdateGeneralSetting('gamification_status', $g_status);

        if ($g_status) {
            $point_status = $request->get('gamification_point_status', 0);
            UpdateGeneralSetting('gamification_point_status', $point_status);
            if ($point_status) {
                $settings = [
                    'gamification_point_each_login_status' => $request->get('gamification_point_each_login_status', 0),
                    'gamification_point_each_login_point' => $request->get('gamification_point_each_login_point', 0),

                    'gamification_point_each_unit_complete_status' => $request->get('gamification_point_each_unit_complete_status', 0),
                    'gamification_point_each_unit_complete_point' => $request->get('gamification_point_each_unit_complete_point', 0),

                    'gamification_point_each_course_complete_status' => $request->get('gamification_point_each_course_complete_status', 0),
                    'gamification_point_each_course_complete_point' => $request->get('gamification_point_each_course_complete_point', 0),

                    'gamification_point_each_certificate_status' => $request->get('gamification_point_each_certificate_status', 0),
                    'gamification_point_each_certificate_point' => $request->get('gamification_point_each_certificate_point', 0),

                    'gamification_point_each_test_complete_status' => $request->get('gamification_point_each_test_complete_status', 0),
                    'gamification_point_each_test_complete_point' => $request->get('gamification_point_each_test_complete_point', 0),

                    'gamification_point_each_assignment_complete_status' => $request->get('gamification_point_each_assignment_complete_status', 0),
                    'gamification_point_each_assignment_complete_point' => $request->get('gamification_point_each_assignment_complete_point', 0),

                    'gamification_point_each_comment_status' => $request->get('gamification_point_each_comment_status', 0),
                    'gamification_point_each_comment_point' => $request->get('gamification_point_each_comment_point', 0),

                ];
                $this->updateSetting($settings);
            }

            $badge_status = $request->get('gamification_badges_status', 0);
            UpdateGeneralSetting('gamification_badges_status', $badge_status);
            if ($badge_status) {
                $settings = [
                    'gamification_badges_activity_status' => $request->get('gamification_badges_activity_status', 0),
                    'gamification_badges_registration_status' => $request->get('gamification_badges_registration_status', 0),
                    'gamification_badges_courses_status' => $request->get('gamification_badges_courses_status', 0),
                    'gamification_badges_rating_status' => $request->get('gamification_badges_rating_status', 0),
                    'gamification_badges_sales_status' => $request->get('gamification_badges_sales_status', 0),
                    'gamification_badges_blogs_status' => $request->get('gamification_badges_blogs_status', 0),
                    'gamification_badges_learning_status' => $request->get('gamification_badges_learning_status', 0),
                    'gamification_badges_test_status' => $request->get('gamification_badges_test_status', 0),
                    'gamification_badges_assignment_status' => $request->get('gamification_badges_assignment_status', 0),
                    'gamification_badges_perfectionism_status' => $request->get('gamification_badges_perfectionism_status', 0),
                    'gamification_badges_survey_status' => $request->get('gamification_badges_survey_status', 0),
                    'gamification_badges_communication_status' => $request->get('gamification_badges_communication_status', 0),
                    'gamification_badges_certification_status' => $request->get('gamification_badges_certification_status', 0),
                ];
                $this->updateSetting($settings);
            }


            $level_status = $request->get('gamification_level_status', 0);
            UpdateGeneralSetting('gamification_level_status', $level_status);
            if ($level_status) {
                $settings = [
                    'gamification_level_entry_point_status' => $request->get('gamification_level_entry_point_status', 0),
                    'gamification_level_entry_point' => $request->get('gamification_level_entry_point', 0),

                    'gamification_level_entry_complete_status' => $request->get('gamification_level_entry_complete_status', 0),
                    'gamification_level_entry_complete_point' => $request->get('gamification_level_entry_complete_point', 0),

                    'gamification_level_entry_badge_status' => $request->get('gamification_level_entry_badge_status', 0),
                    'gamification_level_entry_badge_point' => $request->get('gamification_level_entry_badge_point', 0),
                ];
                $this->updateSetting($settings);
            }


            $reward_status = $request->get('gamification_reward_status', 0);
            UpdateGeneralSetting('gamification_reward_status', $reward_status);
            if ($reward_status) {
                $settings = [
                    'gamification_reward_discount_course_point_status' => $request->get('gamification_reward_discount_course_point_status', 0),
                    'gamification_reward_discount_course_point' => $request->get('gamification_reward_discount_course_point', ''),
                    'gamification_reward_course_point' => $request->get('gamification_reward_course_point', ''),

                    'gamification_reward_discount_course_badge_status' => $request->get('gamification_reward_discount_course_badge_status', 0),
                    'gamification_reward_discount_course_badge' => $request->get('gamification_reward_discount_course_badge', ''),
                    'gamification_reward_course_badge' => $request->get('gamification_reward_course_badge', ''),

                    'gamification_reward_discount_course_level_status' => $request->get('gamification_reward_discount_course_level_status', 0),
                    'gamification_reward_discount_course_level' => $request->get('gamification_reward_discount_course_level', ''),
                    'gamification_reward_course_level' => $request->get('gamification_reward_course_level', ''),

                    'gamification_reward_point_conversion_status' => $request->get('gamification_reward_point_conversion_status', 0),
                    'gamification_reward_point_conversion_rate' => $request->get('gamification_reward_point_conversion_rate', 0),

                ];
                $this->updateSetting($settings);
            }
            $leaderboard_status = $request->get('gamification_leaderboard_status', 0);
            UpdateGeneralSetting('gamification_leaderboard_status', $leaderboard_status);
            if ($leaderboard_status) {
                $settings = [
                    'gamification_leaderboard_show_level_status' => $request->get('gamification_leaderboard_show_level_status', 0),
                    'gamification_leaderboard_show_point_status' => $request->get('gamification_leaderboard_show_point_status', 0),
                    'gamification_leaderboard_show_badges_status' => $request->get('gamification_leaderboard_show_badges_status', 0),
                    'gamification_leaderboard_show_courses_status' => $request->get('gamification_leaderboard_show_courses_status', 0),
                    'gamification_leaderboard_show_certificate_status' => $request->get('gamification_leaderboard_show_certificate_status', 0),
                ];
                $this->updateSetting($settings);
            }

            $leaderboard_filter_status = $request->get('gamification_leaderboard_filter_status', 0);
            UpdateGeneralSetting('gamification_leaderboard_filter_status', $leaderboard_filter_status);
            if ($leaderboard_filter_status) {
                $settings = [
                    'gamification_leaderboard_filter_course_level_status' => $request->get('gamification_leaderboard_filter_course_level_status', 0),
                    'gamification_leaderboard_filter_class_status' => $request->get('gamification_leaderboard_filter_class_status', 0),
                    'gamification_leaderboard_filter_institute_status' => $request->get('gamification_leaderboard_filter_institute_status', 0),
                ];
                $this->updateSetting($settings);
            }
        }
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function updateSetting($settings = [])
    {
        foreach ($settings as $key => $setting) {
            UpdateGeneralSetting($key, $setting);
        }
    }

    public function statisticResetModal()
    {
        $users = User::select('id', 'name')
            ->where('status', 1)
            ->where('role_id', 3)
            ->where('teach_via', 1)
            ->orderBy('gamification_total_points', 'desc')
            ->get();
        return view('setting::gamification._modal_statistic_reset', compact('users'));
    }

}
