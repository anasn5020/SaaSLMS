<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\FrontPage;

class AddHomePageColumnInFrontendPage extends Migration
{
    public function up()
    {
        Schema::table('front_pages', function ($table) {
            if (!Schema::hasColumn('front_pages', 'homepage')) {
                $table->tinyInteger('homepage')->default(0);
            }
        });
        $item = FrontPage::where('slug', '/')->first();
        if ($item) {
            $item->homepage = 1;
            $item->save();
        }
    }

    public function down()
    {
        //
    }
}
