<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddColumnInThemeCustomizeTable extends Migration
{
    public function up()
    {
        Schema::table('theme_customizes', function ($table) {
            if (!Schema::hasColumn('theme_customizes', 'theme_name')) {
                $table->text('theme_name')->nullable();
            }
        });


        $customizes = DB::table('theme_customizes')->get();
        foreach ($customizes as $customize) {
            $theme = DB::table('themes')->where('id', $customize->theme_id)->first();
            if ($theme) {
                DB::table('theme_customizes')
                    ->where('theme_id', $theme->id)
                    ->update([
                        'theme_name' => $theme->name
                    ]);
            }
        }
    }

    public function down()
    {
        //
    }
}
