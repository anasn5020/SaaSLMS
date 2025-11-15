<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Model\BusinessSetting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $settings =[
            [
                'type' => 'student_registration_auto_approval',
                'status'=>0
            ],
            [
                'type' => 'instructor_registration_auto_approval',
                'status'=>0
            ],
            [
                'type' => 'topic_comment_auto_approval',
                'status'=>0
            ],
            [
                'type' => 'topic_review_auto_approval',
                'status'=>0
            ],
            [
                'type' => 'blog_comment_auto_approval',
                'status'=>0
            ],
        ];
       BusinessSetting::insert($settings);

        $routes = [
            ['name' => 'Reviews', 'route' => 'reviews', 'type' => 1, 'parent_route' => null],
            ['name' => 'Topic Reviews', 'route' => 'topic.reviews.index', 'type' => 2, 'parent_route' => 'reviews'],
        ];
        permissionUpdateOrCreate($routes);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
