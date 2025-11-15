<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class RemoveAddOthersPermission1 extends Migration
{
    public function up()
    {
        Permission::where('route', 'frontend.page.change-status')->where('type', 2)->delete();


        $setting = Permission::where('route', 'certificate.index')->where('type', 1)->first();
        if ($setting) {
            $setting->parent_route = null;
            $setting->save();
        }


        $setting = Permission::where('route', 'certificate.create')->first();
        if ($setting) {
            $setting->type = 3;
            $setting->save();
        }

        $setting = Permission::where('route', 'settings')->first();
        if ($setting) {
            $setting->name = 'System Setting';
            $setting->save();
        }

        $setting = Permission::where('route', 'setting.updateSystem')->first();
        if ($setting) {
            $setting->name = 'System Update';
            $setting->save();
        }
        $setting = Permission::where('route', 'setting.email_setup')->first();
        if ($setting) {
            $setting->name = 'Email Setup';
            $setting->save();
        }


        $delete_routes = [
            'timezone.index',
            'timezone.edit_modal',
            'timezone.destroy'
        ];

        Permission::whereIn('route', $delete_routes)->delete();
        Permission::where('parent_route', 'timezone.index')->delete();
        if (config('database.default') == 'pgsql') {
            $id = Permission::max('id');
            DB::statement("ALTER SEQUENCE permissions_id_seq RESTART WITH " . ++$id);
        }
        Permission::insert([
            [
                'name' => 'Instructor Setup',
                'route' => 'settings.instructor_setup',
                'parent_route' => 'settings',
                'type' => 2,
            ], [
                'name' => 'Timezone',
                'route' => 'timezone.index',
                'parent_route' => 'settings',
                'type' => 2,
            ], [
                'name' => 'Add',
                'route' => 'timezone.store',
                'parent_route' => 'timezone.index',
                'type' => 3,
            ], [
                'name' => 'Edit',
                'route' => 'timezone.update',
                'parent_route' => 'timezone.index',
                'type' => 3,
            ], [
                'name' => 'Delete',
                'route' => 'timezone.delete',
                'parent_route' => 'timezone.index',
                'type' => 3,
            ],

            [
                'name' => 'City',
                'route' => 'city.index',
                'parent_route' => 'settings',
                'type' => 2,
            ], [
                'name' => 'Add',
                'route' => 'city.store',
                'parent_route' => 'city.index',
                'type' => 3,
            ], [
                'name' => 'Edit',
                'route' => 'city.update',
                'parent_route' => 'city.index',
                'type' => 3,
            ], [
                'name' => 'Delete',
                'route' => 'city.delete',
                'parent_route' => 'city.index',
                'type' => 3,
            ],

            [
                'name' => 'Queue Settings',
                'route' => 'setting.queueSetting',
                'parent_route' => 'settings',
                'type' => 2,
            ], [
                'name' => 'reCaptcha',
                'route' => 'setting.captcha',
                'parent_route' => 'settings',
                'type' => 2,
            ], [
                'name' => 'Social Login',
                'route' => 'setting.socialLogin',
                'parent_route' => 'settings',
                'type' => 2,
            ], [
                'name' => 'Course Setting',
                'route' => 'course.setting',
                'parent_route' => 'courses',
                'type' => 2,
            ], [
                'name' => 'Fonts',
                'route' => 'certificate.fonts',
                'parent_route' => 'certificate.index',
                'type' => 2,
            ], [
                'name' => 'Add',
                'route' => 'certificate.fonts.save',
                'parent_route' => 'certificate.fonts',
                'type' => 3,
            ], [
                'name' => 'Delete',
                'route' => 'certificate.fonts.delete',
                'parent_route' => 'certificate.fonts',
                'type' => 3,
            ],
        ]);

    }

    public function down()
    {
        //
    }
}
