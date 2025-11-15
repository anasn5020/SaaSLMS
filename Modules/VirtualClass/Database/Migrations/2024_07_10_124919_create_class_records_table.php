<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('class_records', function (Blueprint $table) {
            $table->id();
            $table->integer('class_id');
            $table->integer('meeting_id');
            $table->string('title')->nullable();
            $table->text('url')->nullable();
            $table->string('host')->default('self');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::table('virtual_classes', function ($table) {
            if (!Schema::hasColumn('virtual_classes', 'show_record')) {
                $table->integer('show_record')->default(0);
            }

            if (!Schema::hasColumn('virtual_classes', 'record_validity')) {
                $table->integer('record_validity')->default(0)->comment('In days');
            }
        });

        Schema::table('zoom_meetings', function ($table) {
            if (!Schema::hasColumn('zoom_meetings', 'download')) {
                $table->integer('download')->default(0);
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_records');
    }
}
