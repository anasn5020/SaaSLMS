<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class RemoveUnusedSocailSettingAndOthersPermission extends Migration
{
    public function up()
    {
        Permission::withoutEvents(function () {
            $routes = [
                'frontend.socialSetting.topbar_status_update',
                'frontend.socialSetting.footer_status_update',
                'appearance.themes.index',
                'frontend.sectionSetting',
                'frontend.sectionSetting.store',
                "frontend.sectionSetting.edit",
                'frontend.sectionSetting.delete',
                'frontend.sectionSetting.status_update',
                'frontend.sliders.index',
                'frontend.sliders.setting',
                'blog',
                'blogs.index',
                'blog.create',
                'blog.edit',
                'blog.destroy',
                'newsletter.subscriber'
            ];
            Permission::whereIn('route', $routes)->delete();

            $id = Permission::max('id');
            $notificaiton = Permission::where('route', 'notification_setup_list')->where('type', 1)->first();
            if ($notificaiton) {
                $notificaiton->route = 'notification';
                $notificaiton->save();
            }

            $notificaitons = Permission::where('parent_route', 'notification_setup_list')->get();
            foreach ($notificaitons as $not) {
                $not->parent_route = 'notification';
                $not->save();
            }


            $utility = Permission::where('route', 'utility')->first();
            if (empty($utility)) {
                $utility = new Permission();
                $utility->id = ++$id;
            }
            $utility->name = 'Utility';
            $utility->route = 'utility';
            $utility->type = 1;
            $utility->save();

            $utitltyRotues = [
                'ipBlock.index',
                'setting.geoLocation',
                'setting.maintenance',
                'setting.utilities',
                'setting.preloader',
                'setting.error_log'
            ];

            $utitiles = Permission::whereIn('route', $utitltyRotues)->get();

            foreach ($utitiles as $u) {
                $u->parent_route = 'utility';
                $u->save();
            }

            $quizReport = Permission::where('route', 'quizResult')->first();
            if ($quizReport) {
                $quizReport->parent_route = 'reports';
                $quizReport->save();
            }


            Permission::insert([
                [
                   'id' => ++$id,
                    'name' => 'Preloader Setting',
                    'route' => 'setting.preloader',
                    'parent_route' => 'utility',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Error Log',
                    'route' => 'setting.error_log',
                    'parent_route' => 'utility',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Role',
                    'route' => 'permission.roles.index',
                    'parent_route' => 'user.manager',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Student Role',
                    'route' => 'permission.student-roles',
                    'parent_route' => 'user.manager',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Staff Setting',
                    'route' => 'staffs.settings',
                    'parent_route' => 'user.manager',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Banner/Slider Setting',
                    'route' => 'frontend.sliders.setting',
                    'parent_route' => 'frontend_CMS',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Add',
                    'route' => 'frontend.sliders.store',
                    'parent_route' => 'frontend.sliders',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Edit',
                    'route' => 'frontend.sliders.update',
                    'parent_route' => 'frontend.sliders',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Delete',
                    'route' => 'frontend.sliders.destroy',
                    'parent_route' => 'frontend.sliders',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Add',
                    'route' => 'footerSetting.footer.widget-store',
                    'parent_route' => 'footerSetting.footer.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Edit',
                    'route' => 'footerSetting.footer.widget-update',
                    'parent_route' => 'footerSetting.footer.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Delete',
                    'route' => 'footerSetting.footer.widget-delete',
                    'parent_route' => 'footerSetting.footer.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Change Status',
                    'route' => 'footerSetting.footer.widget-status',
                    'parent_route' => 'footerSetting.footer.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Section Update',
                    'route' => 'footerSetting.footer.content-update',
                    'parent_route' => 'footerSetting.footer.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Delete',
                    'route' => 'frontend.page.delete',
                    'parent_route' => 'frontend.page.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Change Status',
                    'route' => 'frontend.page.change-status',
                    'parent_route' => 'frontend.page.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Category',
                    'route' => 'frontend.page.change-status',
                    'parent_route' => 'frontend.page.index',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Blogs',
                    'route' => 'blogs',
                    'parent_route' => null,
                    'type' => 1,
                ],
                [
                    'id' => ++$id,
                    'name' => 'Post',
                    'route' => 'blogs.index',
                    'parent_route' => 'blogs',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Add',
                    'route' => 'blogs.store',
                    'parent_route' => 'blogs.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Edit',
                    'route' => 'blogs.update',
                    'parent_route' => 'blogs.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Delete',
                    'route' => 'blogs.destroy',
                    'parent_route' => 'blogs.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Change Status',
                    'route' => 'blogs.changeStatus',
                    'parent_route' => 'blogs.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Category',
                    'route' => 'blog-category.index',
                    'parent_route' => 'blogs',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Add',
                    'route' => 'blog-category.store',
                    'parent_route' => 'blog-category.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Edit',
                    'route' => 'blog-category.update',
                    'parent_route' => 'blog-category.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Delete',
                    'route' => 'blog-category.destroy',
                    'parent_route' => 'blog-category.index',
                    'type' => 3,
                ], [
                    'id' => ++$id,
                    'name' => 'Change Status',
                    'route' => 'blog-category.changeStatus',
                    'parent_route' => 'blog-category.index',
                    'type' => 3,
                ],
                [
                    'id' => ++$id,
                    'name' => 'Acelle',
                    'route' => 'newsletter.acelle.setting',
                    'parent_route' => 'newsletter',
                    'type' => 2,
                ], [
                    'id' => ++$id,
                    'name' => 'Subscriber',
                    'route' => 'newsletter.subscriber',
                    'parent_route' => 'newsletter',
                    'type' => 2,
                ],
            ]);


            $sponsorDelete = Permission::where('route', 'frontend.sponsors.destroy')->first();
            if ($sponsorDelete) {
                $sponsorDelete->name = 'Delete';
                $sponsorDelete->save();
            }
        });
    }

    public function down()
    {
        //
    }
}
