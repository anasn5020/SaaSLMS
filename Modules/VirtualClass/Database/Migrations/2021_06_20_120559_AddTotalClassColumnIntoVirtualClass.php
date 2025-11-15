<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalClassColumnIntoVirtualClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('virtual_classes', function ($table) {
            if (!Schema::hasColumn('virtual_classes', 'total_class')) {
                $table->integer('total_class')->default(0);
            }
        });

        $classes = \Modules\VirtualClass\Entities\VirtualClass::all();
        foreach ($classes as $class) {
            if ($class == "Zoom") {
                $class->total_class = count($class->zoomMeetings);
            } elseif ($class == "BBB") {
                $class->total_class = count($class->bbbMeetings);
            } elseif ($class == "Jitsi") {
                $class->total_class = count($class->jitsiMeetings);
            }
            $class->save();
        }

    }

    /**m-`
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
