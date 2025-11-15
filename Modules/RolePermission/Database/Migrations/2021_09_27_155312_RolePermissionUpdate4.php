<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolePermissionUpdate4 extends Migration
{

    public function up()
    {
        $sql = [
            ['id' => 371, 'module_id' => 7, 'parent_id' => 109, 'name' => 'Question Bulk Import', 'route' => 'question-bank-bulk', 'type' => 3],
        ];
        DB::table('permissions')->insert($sql);
    }

    public function down()
    {
        //
    }
}
