<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\FrontendManage\Entities\FrontPage;

class CreateFrontPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_pages', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('title')->nullable();
            $table->text('sub_title')->nullable();
            $table->longText('details')->nullable();
            $table->string('slug')->unique();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_static')->default(1);
            $table->timestamps();
        });
        app()->setLocale('en');

        FrontPage::withoutEvents(function () {
            FrontPage::create([
                'name' => 'Teacher directory',
                'title' => 'Teacher directory',
                'slug' => 'teacher-directory',
                'is_static' => 0,
                'sub_title' => 'Learn from industry experts',
                'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text
            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book'
            ], [
                'name' => 'Unlimited access',
                'title' => 'Unlimited access',
                'slug' => 'feature',
                'is_static' => 0,
                'sub_title' => 'Learn on your schedule',
                'details' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text
            ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book'
            ]);
        });


    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('front_pages');
    }
}
