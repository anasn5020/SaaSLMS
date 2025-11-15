<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class AddAndUpdateMenuItem2 extends Migration
{
    public function up()
    {
        //
        Permission::where('route', 'headermenu-list')->delete();

        Permission::where('parent_route', 'headermenu')
            ->update([
                'parent_route' => 'frontend.headermenu'
            ]);

        Permission::where('route', 'newsletter.subscriberDelete')
            ->update([
                'type' => 3,
                'parent_route' => 'newsletter.subscriber'
            ]);

//        Permission::where('route', 'hr.department.store')
//            ->update([
//                'type' => 3,
//                'parent_route' => 'hr.department.index'
//            ]);


    }

    public function down()
    {
        //
    }
}
