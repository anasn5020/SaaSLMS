<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Blog\Entities\Blog;

class AddAuthoredDateTimeColumnInBlog extends Migration
{
    public function up()
    {
        Schema::table('blogs', function ($table) {
            if (!Schema::hasColumn('blogs', 'authored_date_time')) {
                $table->timestamp('authored_date_time')->nullable();
            }
        });


        $blogs = DB::table('blogs')->select('id', 'authored_date', 'authored_time')->get();
        foreach ($blogs as $blog) {
            try {
                $dateTime = Carbon::parse($blog->authored_date . ' ' . $blog->authored_time);
            } catch (\Exception $exception) {
                $dateTime = null;
            }
            DB::table('blogs')->where('id', $blog->id)->update([
                'authored_date_time' => $dateTime
            ]);
        }
    }


    public function down()
    {
        //
    }
}
