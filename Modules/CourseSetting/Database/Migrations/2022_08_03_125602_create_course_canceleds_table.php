<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class CreateCourseCanceledsTable extends Migration
{
    public function up()
    {
        Schema::create('course_canceleds', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('course_id');
            $table->float('purchase_price', 12);
            $table->boolean('refund')->default(0);
            $table->integer('cancel_by')->nullable();
            $table->timestamps();
        });
        if (config('database.default') == 'pgsql') {
            $id = Permission::max('id');
            DB::statement("ALTER SEQUENCE permissions_id_seq RESTART WITH " . ++$id);
        }

        $routes = [
            [
                'name' => 'Enrollment Cancellation',
                'status' => 1,
                'type' => 1,
                'route' => 'enrollmentCancellation',
                'backend' => 0,
                'parent_route' => null
            ]
        ];

        permissionUpdateOrCreate($routes);

    }

    public function down()
    {
        Schema::dropIfExists('course_canceleds');
    }
}
