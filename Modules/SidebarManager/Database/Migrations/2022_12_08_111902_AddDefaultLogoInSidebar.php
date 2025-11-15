<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddDefaultLogoInSidebar extends Migration
{

    public function up()
    {
        $permissions = Permission::where('type', 1)->get();
        foreach ($permissions as $permission) {
            $route = $permission->route;

            if ($route == 'students' || $route == 'instructors') {
                $icon = 'fas fa-user';
            } elseif ($route == 'courses') {
                $icon = 'fas fa-book';
            } elseif ($route == 'quiz') {
                $icon = 'fas fa-question-circle';
            } elseif ($route == 'reports') {
                $icon = 'fas fa-chart-area';
            } elseif ($route == 'communications') {
                $icon = 'fas fa-comments';
            } elseif ($route == 'settings') {
                $icon = 'fas fa-cogs';
            } elseif ($route == 'frontend_CMS') {
                $icon = 'fas fa-paint-roller';
            } elseif ($route == 'certificate') {
                $icon = 'fas fa-certificate';
            } elseif ($route == 'virtual-class') {
                $icon = 'fas fa-vr-cardboard';
            } elseif ($route == 'utility') {
                $icon = 'fas fa-hammer';
            } elseif ($route == 'coupons') {
                $icon = 'fas fa-cube';
            } elseif ($route == 'payments') {
                $icon = 'fas fa-money-bill-alt';
            } elseif ($route == 'notification') {
                $icon = 'fas fa-bell';
            } elseif ($route == 'blogs') {
                $icon = 'fas fa-blog';
            } else {
                $icon = 'fas fa-th';
            }

            $permission->icon = $icon;
            $permission->save();
        }
    }


    public function down()
    {
        //
    }
}
