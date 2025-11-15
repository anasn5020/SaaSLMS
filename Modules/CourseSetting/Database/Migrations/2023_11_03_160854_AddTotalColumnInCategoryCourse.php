<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\Quiz\Entities\OnlineQuiz;

class AddTotalColumnInCategoryCourse extends Migration
{
    public function up()
    {
        Schema::table('categories', function ($table) {
            if (!Schema::hasColumn('categories', 'total_courses')) {
                $table->integer('total_courses')->nullable()->default(0);
            }
            if (!Schema::hasColumn('categories', 'total_quizzes')) {
                $table->integer('total_quizzes')->nullable()->default(0);
            }
        });


        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'total_chapters')) {
                $table->integer('total_chapters')->nullable()->default(0);
            }
            if (!Schema::hasColumn('courses', 'total_lessons')) {
                $table->integer('total_lessons')->nullable()->default(0);
            }
            if (!Schema::hasColumn('courses', 'total_quiz_lessons')) {
                $table->integer('total_quiz_lessons')->nullable()->default(0);
            }
            if (!Schema::hasColumn('courses', 'total_comments')) {
                $table->integer('total_comments')->nullable()->default(0);
            }
            if (!Schema::hasColumn('courses', 'total_reviews')) {
                $table->integer('total_reviews')->nullable()->default(0);
            }
        });

        Schema::table('online_quizzes', function ($table) {
            if (!Schema::hasColumn('online_quizzes', 'total_questions')) {
                $table->integer('total_questions')->nullable()->default(0);
            }
            if (!Schema::hasColumn('online_quizzes', 'total_marks')) {
                $table->integer('total_marks')->nullable()->default(0);
            }
        });

        $courses = \Modules\CourseSetting\Entities\Course::all();
        foreach ($courses as $course) {
            $this->updateTotalCountForCourse($course);
        }

        $categories = \Modules\CourseSetting\Entities\Category::all();
        foreach ($categories as $category) {
            $this->updateTotalCountForCategory($category);
        }


        $quizzes = OnlineQuiz::all();
        foreach ($quizzes as $quiz) {
            $quiz->total_marks = $quiz->totalMarks() ?? 0;
            $quiz->total_questions = $quiz->totalQuestions() ?? 0;
            $quiz->save();
        }
    }

    public function updateTotalCountForCategory($category)
    {

        $category->total_courses = count($category->courses);
        $category->total_quizzes = $category->QuizzesCount;
        $category->save();
    }

    public function updateTotalCountForCourse($course)
    {
        $course->total_chapters = count($course->chapters);
        $course->total_lessons = count($course->lessons);
        $course->total_quiz_lessons = count($course->lessonQuizzes);
        $course->total_comments = count($course->comments);
        $course->total_reviews = count($course->reviews);
        $course->save();
    }

    public function down()
    {
        //
    }
}
