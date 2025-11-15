<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEcommarceColumnInEmailTemplete extends Migration
{
    public function up()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('email_templates', 'ecommerce')) {
                $table->tinyInteger('ecommerce')->default(0);
            }
        });

        $acts = [
            'OffLine_Payment',
            'Bank_Payment',
            'Course_Enroll_Payment',
            'Deduct_Payment',
            'Enroll_Refund',
        ];

        foreach ($acts as $act) {
            DB::table('email_templates')
                ->where('act', $act)
                ->update(['ecommerce' => 1]);

            DB::table('role_email_templates')
                ->where('template_act', $act)
                ->update([
                    'template_act' => $act,
                    'role_id' => 3,
                    'status' => 1,
                ]);
        }


    }

    public function down()
    {
        //
    }
}
