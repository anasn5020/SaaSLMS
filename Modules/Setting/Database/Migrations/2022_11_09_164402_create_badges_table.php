<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Setting\Entities\Badge;

class CreateBadgesTable extends Migration
{
    public function up()
    {
        $table = 'badges';

        if (!Schema::hasTable($table))
            Schema::create($table, function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('type')->nullable();
                $table->string('image')->nullable();
                $table->integer('point')->default(0);
                $table->tinyInteger('status')->default(1);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();
            });


        $badges = [
            ['title' => 'Newbie', 'type' => 'activity', 'image' => 'public/badges/activity/1.png', 'point' => 4],
            ['title' => 'Grower', 'type' => 'activity', 'image' => 'public/badges/activity/2.png', 'point' => 8],
            ['title' => 'Adventurer', 'type' => 'activity', 'image' => 'public/badges/activity/3.png', 'point' => 16],
            ['title' => 'Explorer', 'type' => 'activity', 'image' => 'public/badges/activity/4.png', 'point' => 32],
            ['title' => 'Star', 'type' => 'activity', 'image' => 'public/badges/activity/5.png', 'point' => 64],
            ['title' => 'Superstar', 'type' => 'activity', 'image' => 'public/badges/activity/6.png', 'point' => 128],
            ['title' => 'Master', 'type' => 'activity', 'image' => 'public/badges/activity/7.png', 'point' => 256],
            ['title' => 'Grandmaster', 'type' => 'activity', 'image' => 'public/badges/activity/8.png', 'point' => 512],

            //reg 1,7,30, 60, 90, 120, 150, 365
            ['title' => 'Newbie', 'type' => 'registration', 'image' => 'public/badges/registration/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'registration', 'image' => 'public/badges/registration/2.png', 'point' => 7],
            ['title' => 'Adventurer', 'type' => 'registration', 'image' => 'public/badges/registration/3.png', 'point' => 30],
            ['title' => 'Explorer', 'type' => 'registration', 'image' => 'public/badges/registration/4.png', 'point' => 60],
            ['title' => 'Star', 'type' => 'registration', 'image' => 'public/badges/registration/5.png', 'point' => 90],
            ['title' => 'Superstar', 'type' => 'registration', 'image' => 'public/badges/registration/6.png', 'point' => 120],
            ['title' => 'Master', 'type' => 'registration', 'image' => 'public/badges/registration/7.png', 'point' => 150],
            ['title' => 'Grandmaster', 'type' => 'registration', 'image' => 'public/badges/registration/8.png', 'point' => 365],

            //learning 8, 16, 32, 64, 128
            ['title' => 'Newbie', 'type' => 'learning', 'image' => 'public/badges/learning/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'learning', 'image' => 'public/badges/learning/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'learning', 'image' => 'public/badges/learning/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'learning', 'image' => 'public/badges/learning/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'learning', 'image' => 'public/badges/learning/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'learning', 'image' => 'public/badges/learning/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'learning', 'image' => 'public/badges/learning/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'learning', 'image' => 'public/badges/learning/8.png', 'point' => 128],
            //test 2, 4, 8, 16, 32, 64, 128, 256
            ['title' => 'Newbie', 'type' => 'test', 'image' => 'public/badges/test/1.png', 'point' => 2],
            ['title' => 'Grower', 'type' => 'test', 'image' => 'public/badges/test/2.png', 'point' => 4],
            ['title' => 'Adventurer', 'type' => 'test', 'image' => 'public/badges/test/3.png', 'point' => 8],
            ['title' => 'Explorer', 'type' => 'test', 'image' => 'public/badges/test/4.png', 'point' => 16],
            ['title' => 'Star', 'type' => 'test', 'image' => 'public/badges/test/5.png', 'point' => 32],
            ['title' => 'Superstar', 'type' => 'test', 'image' => 'public/badges/test/6.png', 'point' => 64],
            ['title' => 'Master', 'type' => 'test', 'image' => 'public/badges/test/7.png', 'point' => 128],
            ['title' => 'Grandmaster', 'type' => 'test', 'image' => 'public/badges/test/8.png', 'point' => 256],

            //perfectionism
            ['title' => 'Newbie', 'type' => 'perfectionism', 'image' => 'public/badges/perfectionism/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'perfectionism', 'image' => 'public/badges/perfectionism/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'perfectionism', 'image' => 'public/badges/perfectionism/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'perfectionism', 'image' => 'public/badges/perfectionism/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'perfectionism', 'image' => 'public/badges/perfectionism/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'perfectionism', 'image' => 'public/badges/perfectionism/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'perfectionism', 'image' => 'public/badges/perfectionism/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'perfectionism', 'image' => 'public/badges/perfectionism/8.png', 'point' => 128],

            //communication
            ['title' => 'Newbie', 'type' => 'communication', 'image' => 'public/badges/communication/1.png', 'point' => 2],
            ['title' => 'Grower', 'type' => 'communication', 'image' => 'public/badges/communication/2.png', 'point' => 4],
            ['title' => 'Adventurer', 'type' => 'communication', 'image' => 'public/badges/communication/3.png', 'point' => 8],
            ['title' => 'Explorer', 'type' => 'communication', 'image' => 'public/badges/communication/4.png', 'point' => 16],
            ['title' => 'Star', 'type' => 'communication', 'image' => 'public/badges/communication/5.png', 'point' => 32],
            ['title' => 'Superstar', 'type' => 'communication', 'image' => 'public/badges/communication/6.png', 'point' => 64],
            ['title' => 'Master', 'type' => 'communication', 'image' => 'public/badges/communication/7.png', 'point' => 128],
            ['title' => 'Grandmaster', 'type' => 'communication', 'image' => 'public/badges/communication/8.png', 'point' => 256],
            //certification
            ['title' => 'Newbie', 'type' => 'certification', 'image' => 'public/badges/certification/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'certification', 'image' => 'public/badges/certification/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'certification', 'image' => 'public/badges/certification/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'certification', 'image' => 'public/badges/certification/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'certification', 'image' => 'public/badges/certification/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'certification', 'image' => 'public/badges/certification/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'certification', 'image' => 'public/badges/certification/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'certification', 'image' => 'public/badges/certification/8.png', 'point' => 128],
            //assignment
            ['title' => 'Newbie', 'type' => 'assignment', 'image' => 'public/badges/assignment/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'assignment', 'image' => 'public/badges/assignment/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'assignment', 'image' => 'public/badges/assignment/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'assignment', 'image' => 'public/badges/assignment/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'assignment', 'image' => 'public/badges/assignment/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'assignment', 'image' => 'public/badges/assignment/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'assignment', 'image' => 'public/badges/assignment/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'assignment', 'image' => 'public/badges/assignment/8.png', 'point' => 128],
            //survey
            ['title' => 'Newbie', 'type' => 'survey', 'image' => 'public/badges/survey/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'survey', 'image' => 'public/badges/survey/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'survey', 'image' => 'public/badges/survey/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'survey', 'image' => 'public/badges/survey/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'survey', 'image' => 'public/badges/survey/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'survey', 'image' => 'public/badges/survey/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'survey', 'image' => 'public/badges/survey/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'survey', 'image' => 'public/badges/survey/8.png', 'point' => 128],
            //forum
            ['title' => 'Newbie', 'type' => 'forum', 'image' => 'public/badges/forum/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'forum', 'image' => 'public/badges/forum/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'forum', 'image' => 'public/badges/forum/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'forum', 'image' => 'public/badges/forum/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'forum', 'image' => 'public/badges/forum/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'forum', 'image' => 'public/badges/forum/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'forum', 'image' => 'public/badges/forum/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'forum', 'image' => 'public/badges/forum/8.png', 'point' => 128],

            //courses
            ['title' => 'Newbie', 'type' => 'courses', 'image' => 'public/badges/courses/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'courses', 'image' => 'public/badges/courses/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'courses', 'image' => 'public/badges/courses/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'courses', 'image' => 'public/badges/courses/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'courses', 'image' => 'public/badges/courses/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'courses', 'image' => 'public/badges/courses/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'courses', 'image' => 'public/badges/courses/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'courses', 'image' => 'public/badges/courses/8.png', 'point' => 128],

            //rating
            ['title' => 'Newbie', 'type' => 'rating', 'image' => 'public/badges/rating/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'rating', 'image' => 'public/badges/rating/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'rating', 'image' => 'public/badges/rating/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'rating', 'image' => 'public/badges/rating/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'rating', 'image' => 'public/badges/rating/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'rating', 'image' => 'public/badges/rating/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'rating', 'image' => 'public/badges/rating/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'rating', 'image' => 'public/badges/rating/8.png', 'point' => 128],
            //sales
            ['title' => 'Newbie', 'type' => 'sales', 'image' => 'public/badges/sales/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'sales', 'image' => 'public/badges/sales/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'sales', 'image' => 'public/badges/sales/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'sales', 'image' => 'public/badges/sales/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'sales', 'image' => 'public/badges/sales/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'sales', 'image' => 'public/badges/sales/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'sales', 'image' => 'public/badges/sales/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'sales', 'image' => 'public/badges/sales/8.png', 'point' => 128],
            //blogs
            ['title' => 'Newbie', 'type' => 'blogs', 'image' => 'public/badges/blog/1.png', 'point' => 1],
            ['title' => 'Grower', 'type' => 'blogs', 'image' => 'public/badges/blog/2.png', 'point' => 2],
            ['title' => 'Adventurer', 'type' => 'blogs', 'image' => 'public/badges/blog/3.png', 'point' => 4],
            ['title' => 'Explorer', 'type' => 'blogs', 'image' => 'public/badges/blog/4.png', 'point' => 8],
            ['title' => 'Star', 'type' => 'blogs', 'image' => 'public/badges/blog/5.png', 'point' => 16],
            ['title' => 'Superstar', 'type' => 'blogs', 'image' => 'public/badges/blog/6.png', 'point' => 32],
            ['title' => 'Master', 'type' => 'blogs', 'image' => 'public/badges/blog/7.png', 'point' => 64],
            ['title' => 'Grandmaster', 'type' => 'blogs', 'image' => 'public/badges/blog/8.png', 'point' => 128],

        ];

        Badge::insert($badges);

    }

    public function down()
    {
        Schema::dropIfExists('badges');
    }
}
