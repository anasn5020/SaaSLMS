<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexColoumAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('categories', function ($table) {
            $table->index(['name']);
        });

        Schema::table('sub_categories', function ($table) {
            $table->index(['category_id', 'name']);
        });

        Schema::table('courses', function ($table) {
            $table->index(['category_id', 'subcategory_id', 'user_id', 'lang_id',]);
        });

        Schema::table('coupons', function ($table) {
            $table->index(['code', 'type', 'category_id', 'subcategory_id']);
        });

        Schema::table('question_banks', function ($table) {
            $table->index(['category_id', 'sub_category_id', 'user_id']);
        });

        Schema::table('question_groups', function ($table) {
            $table->index(['user_id']);
        });




        Schema::table('messages', function ($table) {
            $table->index(['sender_id', 'reciever_id']);
        });


        Schema::table('bank_payment_requests', function ($table) {
            $table->index(['user_id']);
        });

        Schema::table('offline_payments', function ($table) {
            $table->index(['user_id', 'role_id', 'amount']);
        });


        Schema::table('payment_methods', function ($table) {
            $table->index(['method', 'active_status']);
        });

        Schema::table('header_menus', function ($table) {
            $table->index(['element_id', 'parent_id']);
        });



        Schema::table('virtual_classes', function ($table) {
            $table->index(['category_id', 'sub_category_id', 'type']);
        });
        Schema::table('blogs', function ($table) {
            $table->index(['user_id', 'slug']);
        });

        Schema::table('themes', function ($table) {
            $table->index(['name', 'folder_path']);
        });
        Schema::table('languages', function ($table) {
            $table->index(['code', 'name', 'rtl']);
        });

        Schema::table('currencies', function ($table) {
            $table->index(['name', 'code', 'symbol']);
        });

        Schema::table('date_formats', function ($table) {
            $table->index(['format']);
        });
        Schema::table('spn_cities', function ($table) {
            $table->index(['name', 'country_id']);
        });

        Schema::table('modules', function ($table) {
            $table->index(['name']);
        });

        Schema::table('infix_module_managers', function ($table) {
            $table->index(['name', 'purchase_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
