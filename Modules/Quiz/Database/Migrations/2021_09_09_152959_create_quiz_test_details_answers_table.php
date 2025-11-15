<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizTestDetailsAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quiz_test_details', function($table){
            $table->integer("ans_id")->nullable()->change();
        });
//        DB::unprepared('ALTER TABLE `quiz_test_details` CHANGE `ans_id` `ans_id` INT(11) NULL;');

        Schema::create('quiz_test_details_answers', function (Blueprint $table) {
            $table->id();
            $table->integer('quiz_test_details_id');
            $table->integer('ans_id');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_test_details_answers');
    }
}
