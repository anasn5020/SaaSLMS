<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FooterSetting\Entities\FooterWidget;

class AddPagesToFooterWidget extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        app()->setLocale('en');
        // Start certificate-verification

        FrontPage::withoutEvents(function () {
            $search_certificate = FrontPage::where('slug', 'certificate-verification')->first();
            if (!$search_certificate) {
                $search_certificate = FrontPage::create([
                    'name' => 'certificate-verification',
                    'title' => 'Certificate Verification',
                    'sub_title' => 'certificate-verification',
                    'details' => "",
                    'slug' => 'certificate-verification',
                    'status' => 1,
                    'is_static' => 1,
                ]);

            }

            FooterWidget::withoutEvents(function () use ($search_certificate) {
//                $certificate = FrontPage::where('slug', 'certificate-verification')->first();

                $check_certificate = FooterWidget::where('slug', 'certificate-verification')->first();
                if ($check_certificate == null) {
                    $check_certificate = new FooterWidget();
                    $check_certificate->name = 'Certificate Verification';
                    $check_certificate->slug = $search_certificate->slug;
                    $check_certificate->category = 3;
                    $check_certificate->section = 3;
                    $check_certificate->page_id = $search_certificate->id;
                    $check_certificate->status = 1;
                    $check_certificate->user_id = 1;
                    $check_certificate->is_static = $search_certificate->is_static;
                    $check_certificate->description = '';
                    $check_certificate->save();
                }
            });
            // End certificate-verification


            // Start free-course


            $free_course = FrontPage::where('slug', 'free-course')->first();
            if (!$free_course) {
                $free_course = DB::table('front_pages')->insert([
                    'name' => 'free-course',
                    'title' => 'Free Course',
                    'sub_title' => 'free-course',
                    'details' => "",
                    'slug' => 'free-course',
                    'status' => 1,
                    'is_static' => 1,
                ]);

            }
            FooterWidget::withoutEvents(function () {
                $course = FrontPage::where('slug', 'free-course')->first();

                $check_course = FooterWidget::where('slug', 'free-course')->first();
                if ($check_course == null) {
                    $check_course = new FooterWidget();
                    $check_course->name = 'Free Course';
                    $check_course->slug = $course->slug;
                    $check_course->category = 3;
                    $check_course->section = 3;
                    $check_course->page_id = $course->id;
                    $check_course->status = 1;
                    $check_course->user_id = 1;
                    $check_course->is_static = $course->is_static;
                    $check_course->description = '';
                    $check_course->save();
                }
            });
        });
        // End free-course
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
