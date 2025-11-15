<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class ChangeErrorLogTableColumn extends Migration
{
    public function up()
    {
        try {
            DB::statement('ALTER TABLE `error_logs`
    CHANGE `subject` `subject` LONGTEXT  NULL DEFAULT NULL;');

            DB::statement('ALTER TABLE `error_logs`
    CHANGE `url` `url` LONGTEXT  NULL DEFAULT NULL;');

            DB::statement('ALTER TABLE `error_logs`
    CHANGE `agent` `agent` LONGTEXT  NULL DEFAULT NULL;');
        } catch (\Exception $e) {

        }
    }

    public function down()
    {
        //
    }
}
