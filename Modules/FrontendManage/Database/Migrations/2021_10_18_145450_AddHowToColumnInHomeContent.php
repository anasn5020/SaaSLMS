<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\HomeContent;

class AddHowToColumnInHomeContent extends Migration
{

    public function up()
    {
        Schema::table('home_contents', function ($table) {

            if (!Schema::hasColumn('home_contents', 'how_to_buy_title1')) {
                $table->text('how_to_buy_title1')->nullable();
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_details1')) {
                $table->text('how_to_buy_details1')->nullable();
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_logo1')) {
                $table->text('how_to_buy_logo1')->nullable();
            }


            if (!Schema::hasColumn('home_contents', 'how_to_buy_title2')) {
                $table->text('how_to_buy_title2')->nullable();
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_details2')) {
                $table->text('how_to_buy_details2')->nullable();
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_logo2')) {
                $table->text('how_to_buy_logo2')->nullable();
            }


            if (!Schema::hasColumn('home_contents', 'how_to_buy_title3')) {
                $table->text('how_to_buy_title3')->nullable();
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_details3')) {
                $table->text('how_to_buy_details3')->nullable();
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_logo3')) {
                $table->text('how_to_buy_logo3')->nullable();
            }


            if (!Schema::hasColumn('home_contents', 'how_to_buy_title4')) {
                $table->text('how_to_buy_title4')->nullable();
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_details4')) {
                $table->text('how_to_buy_details4')->nullable();
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_logo4')) {
                $table->text('how_to_buy_logo4')->nullable();
            }
            if (!Schema::hasColumn('home_contents', 'show_how_to_buy')) {
                $table->integer('show_how_to_buy')->default(0);
            }

            if (!Schema::hasColumn('home_contents', 'how_to_buy_title')) {
                $table->text('how_to_buy_title')->nullable();
            }
            if (!Schema::hasColumn('home_contents', 'how_to_buy_sub_title')) {
                $table->text('how_to_buy_sub_title')->nullable();
            }


        });


        DB::table('home_contents')
            ->where('id', '=', 1)
            ->update([
                "how_to_buy_title" => 'How To Buy',
                "how_to_buy_sub_title" => 'The easiest way to buy stocks is through an online stockbroker. After opening and funding your account.',
                "how_to_buy_title1" => 'Step 1',
                "how_to_buy_title2" => 'Step 2',
                "how_to_buy_title3" => 'Step 3',
                "how_to_buy_title4" => 'Step 4',

                "how_to_buy_details1" =>  'Trusted by companies of all sizes',
                "how_to_buy_details2" =>  'Trusted by companies of all sizes',
                "how_to_buy_details3" =>  'Trusted by companies of all sizes',
                "how_to_buy_details4" =>  'Trusted by companies of all sizes',

                "how_to_buy_logo1" =>   'public/demo/how_to_buy/1.png',
                "how_to_buy_logo2" =>   'public/demo/how_to_buy/2.png',
                "how_to_buy_logo3" =>   'public/demo/how_to_buy/3.png',
                "how_to_buy_logo4" =>   'public/demo/how_to_buy/4.png',
            ]);
    }


    public function down()
    {
        //
    }
}
