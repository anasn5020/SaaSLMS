<?php

use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\HeaderMenu;
use Modules\RolePermission\Entities\Permission;

class UpdateDefaultMenuSidebar extends Migration
{

    public function up()
    {
        $pages = FrontPage::whereIn('slug', ['home0','home1', 'home2', 'home3', 'home4', 'home5', 'home6','home7','home8','home9','home10'])->get();

        foreach ($pages as $key => $page) {
            $item = [
                'type' => $page->is_static ? 'Static Page' : 'Dynamic Page',
                'title' => $page->title,
                'element_id' => $page->id,
                'link' => url($page->slug),
                'parent_id' => 1,
                'position' => ++$key,
                'show' => 0,
                'is_newtab' => 0,
                'mega_menu' => 0,
                'mega_menu_column' => 2,
            ];
            HeaderMenu::create($item);
        }

        $addPermission = Permission::where('route', 'course.store')->first();
        if ($addPermission){
            $addPermission->name = 'Add Course/Quiz';
            $addPermission->parent_route="courses";
            $addPermission->type=2;

            $addPermission->old_name='Add Course/Quiz';
            $addPermission->old_type=2;
            $addPermission->old_parent_route="courses";

            $addPermission->section_id=3;

            $addPermission->position=3;
            $addPermission->save();
        }

    }

    public function down()
    {
        //
    }
}
