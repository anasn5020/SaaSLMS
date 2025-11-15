<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Modules\FrontendManage\Entities\FrontPage;

class AddStaticPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        FrontPage::withoutEvents(function () {
            app()->setLocale('en');
            $check1 = FrontPage::where('slug', '/')->first();
            if (!$check1) {
                $check1 = new FrontPage();
                $check1->name = 'Home';
                $check1->title = 'Home';
                $check1->sub_title = 'Home';
                $check1->details = 'Home Page';
                $check1->slug = '/';
                $check1->status = 1;
                $check1->is_static = 1;
                $check1->save();
            }
            $check2 = FrontPage::where('slug', '/courses')->first();
            if (!$check2) {
                $check2 = new FrontPage();
                $check2->name = 'Courses';
                $check2->title = 'Courses';
                $check2->sub_title = 'Courses';
                $check2->details = 'Courses Page';
                $check2->slug = '/courses';
                $check2->status = 1;
                $check2->is_static = 1;
                $check2->save();
            }


            $check3 = FrontPage::where('slug', '/classes')->first();
            if (!$check3) {
                $check3 = new FrontPage();
                $check3->name = 'Classes';
                $check3->title = 'Classes';
                $check3->sub_title = 'Classes';
                $check3->details = 'Classes Page';
                $check3->slug = '/classes';
                $check3->status = 1;
                $check3->is_static = 1;
                $check3->save();
            }

            $check4 = FrontPage::where('slug', '/quizzes')->first();
            if (!$check4) {
                $check4 = new FrontPage();
                $check4->name = 'Quiz';
                $check4->title = 'Quiz';
                $check4->sub_title = 'Quiz';
                $check4->details = 'Quiz Page';
                $check4->slug = '/quizzes';
                $check4->status = 1;
                $check4->is_static = 1;
                $check4->save();
            }

            $check5 = FrontPage::where('slug', '/instructors')->first();
            if (!$check5) {
                $check5 = new FrontPage();
                $check5->name = 'Instructors';
                $check5->title = 'Instructors';
                $check5->sub_title = 'Instructors';
                $check5->details = 'Instructors Page';
                $check5->slug = '/instructors';
                $check5->status = 1;
                $check5->is_static = 1;
                $check5->save();
            }

            $check6 = FrontPage::where('slug', '/contact-us')->first();
            if (!$check6) {
                $check6 = new FrontPage();
                $check6->name = 'Contact Us';
                $check6->title = 'Contact Us';
                $check6->sub_title = 'Contact Us';
                $check6->details = 'Contact Us Page';
                $check6->slug = '/contact-us';
                $check6->status = 1;
                $check6->is_static = 1;
                $check6->save();
            }

            $check7 = FrontPage::where('slug', 'feature')->first();
            if ($check7) {
                $check7->is_static = 0;
                $check7->save();
            }
            $check8 = FrontPage::where('slug', 'teacher-directory')->first();
            if ($check8) {
                $check8->is_static = 0;
                $check8->save();
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
