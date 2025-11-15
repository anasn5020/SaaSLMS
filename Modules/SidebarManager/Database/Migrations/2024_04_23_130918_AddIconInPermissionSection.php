<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SidebarManager\Entities\PermissionSection;

class AddIconInPermissionSection extends Migration
{
    public function up()
    {
        Schema::table('permission_sections', function (Blueprint $table) {
            if (!Schema::hasColumn('permission_sections', 'icon')) {
                $table->string('icon')->nullable()->default("fas fa-th");
            }
        });

        $sections = PermissionSection::all();
        foreach ($sections as $section) {
            $icon='"fas fa-th"';
            if ($section->id==1){
                $icon ='fas fa-landmark';
            }
            elseif($section->id==2){
                $icon ='fas fa-user-cog';
            }
            elseif($section->id==3){
                $icon ='fas fa-book';
            }
            elseif($section->id==4){
                $icon ='fas fa-cart-arrow-down';
            }
            elseif($section->id==5){
                $icon='fas fa-chalkboard';
            }
            elseif($section->id==6){
                $icon='fas fa-comments';
            }
            elseif($section->id==7){
                $icon='fas fa-toolbox';
            }
            elseif($section->id==8){
                $icon='fas fa-store';
            }
            $section->icon=$icon;
            $section->save();
        }
    }
    public function down()
    {
        //
    }
}
