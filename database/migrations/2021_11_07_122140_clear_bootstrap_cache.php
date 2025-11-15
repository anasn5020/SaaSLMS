<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ClearBootstrapCache extends Migration
{

    public function up()
    {
        File::delete(File::glob('bootstrap/cache/*.php'));
        Artisan::call('optimize:clear',[
            '--no-interaction' => true,
        ]);

    }

    public function down()
    {
        //
    }
}
