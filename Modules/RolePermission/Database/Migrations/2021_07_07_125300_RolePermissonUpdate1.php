<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Permission;

class RolePermissonUpdate1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::withoutEvents(function () {
            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'image_gallery')->first();
            if ($gallery) {
                $gallery->status = 0;
                $gallery->save();

            }

            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'dashboard.overview_of_courses')->first();
            if ($gallery) {
                $gallery->name = 'Overview of Topics';
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'setting.seo_setting')->first();
            if ($gallery) {
                $gallery->name = 'Homepage SEO Setup';
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'AwsS3Setting')->first();
            if ($gallery) {
                $gallery->status = 0;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'bbb')->first();
            if ($gallery) {
                $gallery->status = 0;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'footerEmailConfig')->first();
            if ($gallery) {
                $gallery->status = 0;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'footerEmailConfig')->first();
            if ($gallery) {
                $gallery->module_id = 16;
                $gallery->parent_id = 16;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'appearance.themes.index')->first();
            if ($gallery) {
                $gallery->module_id = 16;
                $gallery->parent_id = 16;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'frontend.subscriber')->first();
            if ($gallery) {
                $gallery->route = 'newsletter.subscriber';
                $gallery->module_id = 334;
                $gallery->parent_id = 334;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'certificate.create')->first();
            if ($gallery) {
                $gallery->type = 2;
                $gallery->parent_id = 19;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'bbb.meetings')->first();
            if ($gallery) {
                $gallery->status = 0;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'zoom.meetings')->first();
            if ($gallery) {
                $gallery->status = 0;
                $gallery->save();
            }


            $gallery = \Modules\RolePermission\Entities\Permission::where('route', 'virtual-class.setting')->first();
            if ($gallery) {
                $gallery->status = 0;
                $gallery->save();
            }


            $sql = [
                ['id' => 304, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Status Overview of Topics', 'route' => 'dashboard.overview_status_of_courses', 'type' => 2],
                ['id' => 305, 'module_id' => 5, 'parent_id' => 5, 'name' => 'Course level', 'route' => 'course-level.index', 'type' => 2],
                ['id' => 306, 'module_id' => 5, 'parent_id' => 305, 'name' => 'Add', 'route' => 'course-level.store', 'type' => 3],
                ['id' => 307, 'module_id' => 5, 'parent_id' => 305, 'name' => 'Edit', 'route' => 'course-level.update', 'type' => 3],
                ['id' => 308, 'module_id' => 5, 'parent_id' => 305, 'name' => 'Delete', 'route' => 'course-level.destroy', 'type' => 3],


                ['id' => 309, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Timezone', 'route' => 'timezone.index', 'type' => 2],
                ['id' => 310, 'module_id' => 12, 'parent_id' => 309, 'name' => 'List', 'route' => 'timezone.index', 'type' => 3],
                ['id' => 311, 'module_id' => 12, 'parent_id' => 309, 'name' => 'Edit', 'route' => 'timezone.edit_modal', 'type' => 3],
                ['id' => 312, 'module_id' => 12, 'parent_id' => 309, 'name' => 'Delete', 'route' => 'timezone.destroy', 'type' => 3],


                ['id' => 313, 'module_id' => 12, 'parent_id' => 12, 'name' => 'City', 'route' => 'city.index', 'type' => 2],
                ['id' => 314, 'module_id' => 12, 'parent_id' => 309, 'name' => 'List', 'route' => 'city.index', 'type' => 3],
                ['id' => 315, 'module_id' => 12, 'parent_id' => 309, 'name' => 'Edit', 'route' => 'city.edit_modal', 'type' => 3],
                ['id' => 316, 'module_id' => 12, 'parent_id' => 309, 'name' => 'Delete', 'route' => 'city.destroy', 'type' => 3],

                ['id' => 317, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Ip Block', 'route' => 'ipBlock.index', 'type' => 2],
                ['id' => 318, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Geo Location', 'route' => 'setting.geoLocation', 'type' => 2],
                ['id' => 319, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Cookie Setting', 'route' => 'setting.cookieSetting', 'type' => 2],
                ['id' => 320, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Cache Setting', 'route' => 'setting.cacheSetting', 'type' => 2],
                ['id' => 321, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Cron Job', 'route' => 'setting.cronJob', 'type' => 2],
                ['id' => 322, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Maintenance', 'route' => 'setting.maintenance', 'type' => 2],
                ['id' => 323, 'module_id' => 12, 'parent_id' => 12, 'name' => 'Utilities', 'route' => 'setting.utilities', 'type' => 2],

                ['id' => 324, 'module_id' => 16, 'parent_id' => 16, 'name' => 'Header menu', 'route' => 'headermenu', 'type' => 2],
                ['id' => 325, 'module_id' => 12, 'parent_id' => 324, 'name' => 'List', 'route' => 'headermenu', 'type' => 3],
                ['id' => 326, 'module_id' => 12, 'parent_id' => 324, 'name' => 'Add Element', 'route' => 'headermenu.add-element', 'type' => 3],
                ['id' => 327, 'module_id' => 12, 'parent_id' => 324, 'name' => 'Edit Element', 'route' => 'headermenu.edit-element', 'type' => 3],
                ['id' => 328, 'module_id' => 12, 'parent_id' => 324, 'name' => 'Reordering', 'route' => 'headermenu.reordering', 'type' => 3],
                ['id' => 329, 'module_id' => 12, 'parent_id' => 324, 'name' => 'Delete', 'route' => 'headermenu.delete', 'type' => 3],

                ['id' => 330, 'module_id' => 16, 'parent_id' => 16, 'name' => 'Page Content', 'route' => 'pageContent', 'type' => 2],
                ['id' => 331, 'module_id' => 16, 'parent_id' => 330, 'name' => 'View', 'route' => 'pageContent', 'type' => 3],
                ['id' => 332, 'module_id' => 16, 'parent_id' => 330, 'name' => 'Update', 'route' => 'pageContentUpdate', 'type' => 3],
                ['id' => 333, 'module_id' => 16, 'parent_id' => 16, 'name' => 'Login & Registration', 'route' => 'loginpage.index', 'type' => 2],


                ['id' => 334, 'module_id' => 334, 'parent_id' => null, 'name' => 'Newsletter', 'route' => 'newsletter', 'type' => 1],
                ['id' => 335, 'module_id' => 334, 'parent_id' => 334, 'name' => 'Setting', 'route' => 'newsletter.setting', 'type' => 2],
                ['id' => 337, 'module_id' => 334, 'parent_id' => 334, 'name' => 'Mailchimp Setting', 'route' => 'newsletter.mailchimp.setting', 'type' => 2],
                ['id' => 338, 'module_id' => 334, 'parent_id' => 334, 'name' => 'Get Response Setting', 'route' => 'newsletter.getresponse.setting', 'type' => 2],
                ['id' => 340, 'module_id' => 334, 'parent_id' => 271, 'name' => 'List', 'route' => 'newsletter.subscriber', 'type' => 3],
                ['id' => 341, 'module_id' => 334, 'parent_id' => 271, 'name' => 'Delete', 'route' => 'newsletter.subscriberDelete', 'type' => 3],


                ['id' => 342, 'module_id' => 342, 'parent_id' => null, 'name' => 'Backup', 'route' => 'backup.index', 'type' => 1],
                ['id' => 343, 'module_id' => 342, 'parent_id' => 342, 'name' => 'Create', 'route' => 'backup.create', 'type' => 2],
                ['id' => 344, 'module_id' => 342, 'parent_id' => 342, 'name' => 'Delete', 'route' => 'backup.delete', 'type' => 2],
                ['id' => 345, 'module_id' => 342, 'parent_id' => 342, 'name' => 'Import', 'route' => 'backup.import', 'type' => 2],

                ['id' => 346, 'module_id' => 5, 'parent_id' => 60, 'name' => 'Delete', 'route' => 'course.delete', 'type' => 3],

            ];

            DB::table('permissions')->insert($sql);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
