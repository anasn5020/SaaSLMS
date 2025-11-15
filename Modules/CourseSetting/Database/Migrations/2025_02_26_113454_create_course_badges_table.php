<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_badges', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('course_id');
            $table->timestamps();
        });

        Schema::table('courses', function ($table) {
            if (!Schema::hasColumn('courses', 'has_badge')) {
                $table->boolean('has_badge')->default(false);
            }
            if (!Schema::hasColumn('courses', 'course_badge')) {
                $table->text('course_badge')->nullable();
            }
        });


        $routes=[
            ['name' => 'Course Badges', 'route' => 'course_badges', 'type' => 1, 'parent_route' => null, 'backend' => 0,],
        ];

        if (function_exists('permissionUpdateOrCreate')) {
            permissionUpdateOrCreate($routes);
        }

    }
    public function down(): void
    {
        Schema::dropIfExists('course_badges');
    }
};
