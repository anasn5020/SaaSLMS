<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\FrontendManage\Entities\FrontPage;

class UpdateFrontendPageTableTranslateable extends Migration
{

    public function up()
    {


        $lang_code = 'en';
        $table_name = 'front_pages';

        Schema::table($table_name, function ($table) {
            $table->longText('title')->nullable()->change();
            $table->longText('sub_title')->nullable()->change();
            $table->longText('details')->nullable()->change();
        });
//        DB::statement('ALTER TABLE `' . $table_name . '`
//    CHANGE `title` `title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `sub_title` `sub_title` LONGTEXT  NULL DEFAULT NULL,
//    CHANGE `details` `details` LONGTEXT  NULL DEFAULT NULL;
//
//    ');

//        $pages = \Modules\FrontendManage\Entities\FrontPage::where('is_static', 0)->get();
//        foreach ($pages as $page) {
//            $page->details = $this->container($page->details, $page->title, $page->subtitle);
//            $page->save();
//        }

        $pages = FrontPage::where('is_static', 0)->get();
        foreach ($pages as $page) {
            DB::table('front_pages')->where('id', $page->id)->update([
                'details' => $this->container($page->details, $page->title, $page->sub_title)
            ]);
        }
    }

    public function container($details, $title = '', $subtitle = '')
    {
        $imagePath = asset('public/frontend/infixlmstheme/img/new_bread_crumb_bg.png');

        $html = "




    <div class='row'>
        <div class='col-sm-12 ui-resizable' data-type='container-content'>
            <div class='breadcrumb_area' style='background-image: url(".$imagePath.");'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='breadcam_wrap'>
                                <h3>".$title." </h3>
                                 <p>  ". __('frontend.Home')." / ".$subtitle." </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-sm-12 ui-resizable' data-type='container-content'>
        <div class='courses_area'><div class='container'><div class='row justify-content-center'><div class='col-lg-12'>

            " . $details . "

            </div></div></div></div>
        </div>
    </div>";

        return $html;
    }

    public function down()
    {
        //
    }
}
