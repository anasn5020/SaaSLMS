<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLmsIdToAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ignoreTables = [
            'spatial_ref_sys',
        ];
        $driver = config('database.default');

        if ($driver === 'mysql') {
            $tables = DB::select('SHOW TABLES');
        } elseif ($driver === 'pgsql') {
            $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
        }
        foreach ($tables as $key => $table_name) {
            $table_name = array_values(get_object_vars($table_name));
            $table_name = $table_name[0] ?? '';
            if (Schema::hasTable($table_name) && !in_array($table_name, $ignoreTables)) {
                Schema::table($table_name, function (Blueprint $table) use ($table_name) {
                    if (!Schema::hasColumn($table_name, 'lms_id')) {
                        $table->integer('lms_id')->default(1);
                    }
                });
            }
        }
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
