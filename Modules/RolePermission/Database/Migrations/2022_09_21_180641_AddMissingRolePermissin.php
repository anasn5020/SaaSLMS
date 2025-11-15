<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddMissingRolePermissin extends Migration
{

    public function up()
    {
        $permission = Permission::where('route', 'question-bank')->first();
        if ($permission) {
            $permission->name = 'Add Question';
            $permission->save();
        }

        $permission = Permission::where('route', 'question-bank-bulk')->first();
        if ($permission) {
            $permission->name = 'Question Import';
            $permission->type = 2;
            $permission->parent_route = 'quiz';
            $permission->save();
        }

        $permission = Permission::where('route', 'certificate.fonts')->first();
        if ($permission) {
            $permission->name = 'Certificate Fonts';
            $permission->parent_route = 'certificate';
            $permission->save();
        }
        $permission = Permission::where('route', 'certificate.create')->first();
        if ($permission) {
            $permission->name = 'Add Certificate';
            $permission->parent_route = 'certificate';
            $permission->type = 2;
            $permission->save();
        }

        $permission = Permission::where('route', 'setting.pushNotification')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Push Notification';
        $permission->route = 'setting.pushNotification';
        $permission->type = 1;
        $permission->position = 999999;
        $permission->save();


        $permission = Permission::where('route', 'frontend.ContactPageContent')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Contact Us';
        $permission->route = 'frontend.ContactPageContent';
        $permission->type = 2;
        $permission->parent_route = 'frontend_CMS';
        $permission->position = 999999;
        $permission->save();


        $permission = Permission::where('route', 'popup-content.index')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Popup Content';
        $permission->route = 'popup-content.index';
        $permission->type = 2;
        $permission->parent_route = 'frontend_CMS';
        $permission->position = 999999;
        $permission->save();


        $permission = Permission::where('route', 'frontend.faq.index')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'FAQ';
        $permission->route = 'frontend.faq.index';
        $permission->type = 2;
        $permission->parent_route = 'frontend_CMS';
        $permission->position = 999999;
        $permission->save();


        $permission = Permission::where('route', 'frontend.faq.store')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Add';
        $permission->route = 'frontend.faq.store';
        $permission->type = 3;
        $permission->parent_route = 'frontend.faq.index';
        $permission->position = 999999;
        $permission->save();

        $permission = Permission::where('route', 'frontend.faq.update')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Edit';
        $permission->route = 'frontend.faq.update';
        $permission->type = 3;
        $permission->parent_route = 'frontend.faq.index';
        $permission->position = 999999;
        $permission->save();

        $permission = Permission::where('route', 'frontend.faq.destroy')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Delete';
        $permission->route = 'frontend.faq.destroy';
        $permission->type = 3;
        $permission->parent_route = 'frontend.faq.index';
        $permission->position = 999999;
        $permission->save();


        $permission = Permission::where('route', 'appearance')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Appearance';
        $permission->route = 'appearance';
        $permission->type = 1;
        $permission->parent_route = null;
        $permission->position = 999999;
        $permission->save();

        $permission = Permission::where('route', 'appearance.themes.index')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Themes';
        $permission->route = 'appearance.themes.index';
        $permission->type = 2;
        $permission->parent_route = 'appearance';
        $permission->position = 999999;
        $permission->save();


        $permission = Permission::where('route', 'appearance.themes-customize.index')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Theme Customize';
        $permission->route = 'appearance.themes-customize.index';
        $permission->type = 2;
        $permission->parent_route = 'appearance';
        $permission->position = 999999;
        $permission->save();

        $permission = Permission::where('route', 'appearance.themes-customize.index')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'Theme Customize';
        $permission->route = 'appearance.themes-customize.index';
        $permission->type = 2;
        $permission->parent_route = 'appearance';
        $permission->position = 999999;
        $permission->save();

        $permission = Permission::where('route', 'gdrive.setting')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'gDrive Configuration';
        $permission->route = 'gdrive.setting';
        $permission->type = 2;
        $permission->parent_route = 'settings';
        $permission->position = 999999;
        $permission->save();


        $permission = Permission::where('route', 'city.index')->first();
        if (!$permission) {
            $permission = new Permission();
        }
        $permission->name = 'City';
        $permission->route = 'city.index';
        $permission->type = 2;
        $permission->parent_route = 'settings';
        $permission->position = 999999;
        $permission->save();


    }


    public function down()
    {
        //
    }
}
