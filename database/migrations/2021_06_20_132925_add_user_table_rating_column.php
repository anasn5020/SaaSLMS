<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\CourseSetting\Entities\Course;

class AddUserTableRatingColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            if (!Schema::hasColumn('users', 'total_rating')) {
                $table->integer('total_rating')->default(0);;
            }

            if (!Schema::hasColumn('users', 'language_rtl')) {
                $table->boolean('language_rtl')->default(false);;
            }
        });

        if (Schema::hasTable('courses')) {
            $users = User::all();
            foreach ($users as $user) {
                $courses = Course::where('user_id', $user->id)->get();
                $rating = 0;
                foreach ($courses as $course) {
                    $rating = $rating + $course->total_rating;
                }

                if (count($courses) != 0) {
                    $avg = ($rating / count($courses));
                } else {
                    $avg = 0;
                }
                $user->language_rtl = $user->userLanguage->rtl;
                $user->total_rating = $avg;

                $user->save();
            }
        }


        Schema::table('users', function ($table) {
            $table->string("username", 191)->nullable()->change();
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
