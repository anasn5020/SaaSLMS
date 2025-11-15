<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInThemeTable extends Migration
{

    public function up()
    {
        Schema::table('themes', function ($table) {
            if (!Schema::hasColumn('themes', 'purchase_code')) {
                $table->text('purchase_code')->nullable();
            }

            if (!Schema::hasColumn('themes', 'email')) {
                $table->text('email')->nullable();
            }

            if (!Schema::hasColumn('themes', 'activated_date')) {
                $table->text('activated_date')->nullable();
            }


            if (!Schema::hasColumn('themes', 'item_code')) {
                $table->text('item_code')->nullable();
            }

            if (!Schema::hasColumn('themes', 'checksum')) {
                $table->text('checksum')->nullable();
            }

            if (!Schema::hasColumn('themes', 'installed_domain')) {
                $table->text('installed_domain')->nullable();
            }

        });
    }


    public function down()
    {
        //
    }
}
