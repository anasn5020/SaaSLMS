<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddParentColumnInLmsInstitute extends Migration
{

    public function up()
    {
        Schema::table('lms_institutes', function ($table) {
            if (!Schema::hasColumn('lms_institutes', 'parent_id')) {
                $table->integer('parent_id')->nullable();
            }
        });
    }


    public function down()
    {
        //
    }
}
