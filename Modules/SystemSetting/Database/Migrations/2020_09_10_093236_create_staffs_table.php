<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('staffs')) {
            Schema::create('staffs', function (Blueprint $table) {
                $table->id();
                $table->string('employee_id', 50)->nullable();
                $table->integer('user_id')->nullable()->default(1)->unsigned();
                $table->integer('department_id')->nullable()->default(1)->unsigned();
                $table->integer('showroom_id')->nullable()->default(1)->unsigned();
                $table->integer('warehouse_id')->nullable()->default(1)->unsigned();
                $table->string('phone', 20)->nullable();
                $table->string('bank_name', 255)->nullable();
                $table->string('bank_branch_name', 255)->nullable();
                $table->string('bank_account_name', 255)->nullable();
                $table->string('bank_account_no', 255)->nullable();
                $table->string('current_address', 255)->nullable();
                $table->string('permanent_address', 255)->nullable();
                $table->string('basic_salary', 255)->nullable();
                $table->string('employment_type', 150)->nullable();
                $table->double("opening_balance", 16, 2)->default(0)->nullable();
                $table->tinyInteger('provisional_months')->default(0);
                $table->date('date_of_joining')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->date('leave_applicable_date')->nullable();
                $table->integer('carry_forward')->default(0);
                $table->boolean('is_carry_active')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
}
