<?php

use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\RolePermission;

class AddGamificationPermission extends Migration
{
    public function up()
    {

        $routes = [
            ['name' => 'Gamification', 'route' => 'gamification', 'type' => 1, 'parent_route' => null],

            ['name' => 'Setting', 'route' => 'gamification.setting', 'type' => 2, 'parent_route' => 'gamification'],
            ['name' => 'Update', 'route' => 'gamification.setting.update', 'type' => 3, 'parent_route' => 'gamification.setting'],
            ['name' => 'Reset to Default', 'route' => 'gamification.setting.reset', 'type' => 3, 'parent_route' => 'gamification.setting'],
            ['name' => 'Reset Statistics', 'route' => 'gamification.reset.statistic', 'type' => 3, 'parent_route' => 'gamification.setting'],

            ['name' => 'Badges', 'route' => 'gamification.badges', 'type' => 2, 'parent_route' => 'gamification'],
            ['name' => 'Add', 'route' => 'gamification.badges.store', 'type' => 3, 'parent_route' => 'gamification.badges'],
            ['name' => 'Edit', 'route' => 'gamification.badges.update', 'type' => 3, 'parent_route' => 'gamification.badges'],
            ['name' => 'Delete', 'route' => 'gamification.badges.delete', 'type' => 3, 'parent_route' => 'gamification.badges'],
            ['name' => 'Change Status', 'route' => 'gamification.badges.status', 'type' => 3, 'parent_route' => 'gamification.badges'],

            ['name' => 'History', 'route' => 'gamification.history', 'type' => 2, 'parent_route' => 'gamification'],

            ['name' => 'Reward Points', 'route' => 'student.gamification.reward', 'type' => 1, 'parent_route' => 'gamification', 'backend' => 0],

        ];

        permissionUpdateOrCreate($routes);

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


            'gamification_level_status' => 1,

            'gamification_level_entry_point_status' => 1,
            'gamification_level_entry_point' => 3000,

            'gamification_level_entry_complete_status' => 1,
            'gamification_level_entry_complete_point' => 5,

            'gamification_level_entry_badge_status' => 1,
            'gamification_level_entry_badge_point' => 5,


            'gamification_reward_status' => 0,

            'gamification_reward_discount_course_point_status' => 0,
            'gamification_reward_discount_course_point' => 10,
            'gamification_reward_course_point' => 1000,

            'gamification_reward_discount_course_badge_status' => 0,
            'gamification_reward_discount_course_badge' => 10,
            'gamification_reward_course_badge' => 50,

            'gamification_reward_discount_course_level_status' => 0,
            'gamification_reward_discount_course_level' => 10,
            'gamification_reward_course_level' => 25,
            'gamification_reward_point_conversion_rate' => 500,


            'gamification_leaderboard_status' => 1,
            'gamification_leaderboard_show_level_status' => 1,
            'gamification_leaderboard_show_point_status' => 1,
            'gamification_leaderboard_show_badges_status' => 1,
            'gamification_leaderboard_show_courses_status' => 0,
            'gamification_leaderboard_show_certificate_status' => 0,
        ];
        foreach ($settings as $key => $setting) {
            UpdateGeneralSetting($key, $setting);
        }


        $permission = Permission::where('route', 'student.gamification.reward')->first();
        if ($permission) {

            RolePermission::insert(
                [
                    'role_id' => 3,
                    'permission_id' => $permission->id,
                    'status' => 1
                ]
            );


        }
    }

    public function down()
    {
        //
    }
}
