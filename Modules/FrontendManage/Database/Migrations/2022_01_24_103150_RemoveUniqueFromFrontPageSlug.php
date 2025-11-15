<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUniqueFromFrontPageSlug extends Migration
{

    public function up()
    {
        try {
            Schema::table('front_pages', function (Blueprint $table) {
                $table->dropUnique('front_pages_slug_unique');
                $table->string('slug', 191)->change();
            });
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
        }
    }


    public function down()
    {
        //
    }
}
