<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPublishColumnInQuizTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_tests', function ($table) {
            if (!Schema::hasColumn('quiz_tests', 'publish')) {
                $table->tinyInteger('publish')->default(0)->comment('0=unpublished, 1= published');
            }
        });
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
