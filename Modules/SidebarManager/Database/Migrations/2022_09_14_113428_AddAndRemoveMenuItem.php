<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddAndRemoveMenuItem extends Migration
{
    public function up()
    {
//        ALTER TABLE `permissions` ADD INDEX(`route`);
//        ALTER TABLE `permissions` CHANGE `parent_route` `parent_route` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
        $delete_routes = [
            'image_gallery',
            'imagegallery.list',
            'imagegallery.store',
            'imagegallery.edit',
            'imagegallery.delete',
            'imagegallery.status_update',
            'course.subcategory',
            'chapterPage'
        ];

        Permission::whereIn('route', $delete_routes)->delete();


        $item = Permission::where('route', 'AwsS3Setting')->first();
        if ($item) {
            $item->module = 'AmazonS3';
            $item->save();
        }

        $item = Permission::where('route', 'notification')->where('type', 1)->first();
        if ($item) {
            $item->parent_route = null;
            $item->save();
        }

        $item = Permission::where('route', 'certificate.index')->where('type', 1)->first();
        if ($item) {
            $item->route = 'certificate';
            $item->parent_route = null;
            $item->save();
        }

        $item = Permission::where('route', 'certificate.index')->where('type', 2)->first();
        if ($item) {
            $item->parent_route = 'certificate';
            $item->save();
        }

        $item = Permission::where('route', 'calendar_show')->where('type', 1)->first();
        if ($item) {
            $item->module = 'Calender';
            $item->route = 'calender';
            $item->parent_route = null;
            $item->save();
        }
        $item = Permission::where('route', 'calendar_show')->where('type', 2)->first();
        if ($item) {
            $item->module = 'Calender';
            $item->parent_route = 'calender';
            $item->save();
        }

        $item = Permission::where('route', 'org')->where('type', 1)->first();
        if ($item) {
            $item->module = 'Org';
            $item->parent_route = null;
            $item->save();
        }

        $item = Permission::where('route', 'Orgsubscription')->where('type', 1)->first();
        if ($item) {
            $item->module = 'OrgSubscription';
            $item->parent_route = null;
            $item->save();
        }
        $item = Permission::where('route', 'OrgInstructorPolicy')->where('type', 1)->first();
        if ($item) {
            $item->module = 'OrgInstructorPolicy';
            $item->parent_route = null;
            $item->save();
        }


        $item = Permission::where('route', 'headermenu')->where('type', 2)->first();
        if ($item) {
            $item->parent_route = null;
            $item->save();
        }
        $item = Permission::where('route', 'headermenu')->where('type', 3)->first();
        if ($item) {
            $item->route = 'headermenu-list';
            $item->parent_route = 'frontend.headermenu';
            $item->save();
        }

//        $item = Permission::where('route', 'hr.department.index')->where('type', 3)->first();
//        if ($item) {
//            $item->route = 'hr.department.store';
//            $item->parent_route = 'hr.department.index';
//            $item->save();
//        }

        $item = Permission::where('route', 'pageContent')->where('type', 2)->first();
        if ($item) {
            $item->parent_route = 'frontend_CMS';
            $item->save();
        }
        $item = Permission::where('route', 'pageContent')->where('type', 3)->first();
        if ($item) {
            $item->route = 'pageContent.view';
            $item->save();
        }

        $item = Permission::where('route', 'homework_list')->where('type', 1)->first();
        if ($item) {
            $item->module = 'Homework';
            $item->route = 'homework';
            $item->parent_route = null;
            $item->save();
        }
        $item = Permission::where('route', 'homework_list')->where('type', 2)->first();
        if ($item) {
            $item->module = 'Homework';
            $item->parent_route = 'homework';
            $item->save();
        }


        $item = Permission::where('route', 'certificate_pro.index')->where('type', 1)->first();
        if ($item) {
            $item->module = 'CertificatePro';
            $item->route = 'certificate_pro';
            $item->parent_route = null;
            $item->save();
        }
        $items = Permission::where('route', 'certificate_pro.index')->where('type', 2)->get();
        foreach ($items as $item) {
            $item->module = 'CertificatePro';
            $item->parent_route = 'certificate_pro';
            $item->save();
        }
        $item = Permission::where('route', 'certificate.index')->where('type', 1)->first();
        if ($item) {
            $item->parent_route = null;
            $item->route = 'certificate';
            $item->save();
        }

        $items = Permission::where('route', 'certificate_pro.index')->where('type', 2)->get();
        foreach ($items as $item) {
            $item->parent_route = 'certificate';
            $item->save();
        }

        $item = Permission::where('route', 'sidebar-manager.index')->first();
        if (!$item) {
            $item = new Permission();
        }
        $item->route = 'sidebar-manager.index';
        $item->name = 'Sidebar Manager';
        $item->type = 1;
        $item->save();

    }

    public function down()
    {
        //
    }
}
