<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsAssignmentColumnToLesson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'certificate_id')) {
                $table->integer('certificate_id')->nullable();
            }

        });

        Schema::table('lessons', function ($table) {
            if (!Schema::hasColumn('lessons', 'is_assignment')) {
                $table->integer('is_assignment')->default(0)->nullable();
            }

        });
        Schema::table('lessons', function ($table) {
            if (!Schema::hasColumn('lessons', 'assignment_id')) {
                $table->integer('assignment_id')->nullable();
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
