<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEcommarceColumnInPermissionTable extends Migration
{

    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'ecommerce')) {
                $table->tinyInteger('ecommerce')->default(0);
            }
        });

        $routes = [
            'dashboard.total_amount_from_enrolled',
            'dashboard.total_revenue',
            'dashboard.total_enrolled_today',
            'dashboard.total_enrolled_this_month',
            'dashboard.monthly_income',
            'dashboard.payment_statistic',
            'deposit',
            'referral',
            'paymentmethodsetting.payment_method_setting',
            'coupons.manage',
            'coupons.common',
            'coupons.single',
            'coupons.personalized',
            'coupons.invite_code',
            'coupons.inviteSettings',
            'onlineLog',
            'offlinePayment',
            'bankPayment.index',
            'admin.reveuneList',
            'admin.reveuneListInstructor',
            'paymentmethodsetting.payment_method_setting',
            'admin.instructor.payout',
            'setting.setCommission',
            'setting.setCourseFee_update',
            'setting.instructorCommission_edit',
            'setting.instructorCommission_update',
            'setting.courseCommission_edit',
            'setting.courseCommission_update',
            'Payments',
            'Coupons',
//            '',
//            '',
//            '',
//            '',
//            '',
//            '',
        ];

        foreach ($routes as $route) {
            DB::table('permissions')
                ->where('route', $route)
                ->update(['ecommerce' => 1]);
        }

        $report = DB::table('permissions')->where('route', 'reports')->first();
        if ($report) {
            $statistic = \Modules\RolePermission\Entities\Permission::where('route', 'course.courseStatistics')->first();
            if ($statistic) {
                $statistic->module_id = $report->id;
                $statistic->parent_id = $report->id;
                $statistic->parent_route = $report->route;
                $statistic->save();
            }
            $quizResult = \Modules\RolePermission\Entities\Permission::where('route', 'quizResult')->first();
            if ($quizResult) {
                $quizResult->module_id = $report->id;
                $statistic->parent_id = $report->id;
                $quizResult->parent_route = $report->route;
                $quizResult->save();
            }
        }


//        $insertId = DB::table('permissions')->insertGetId(
//            [
//                'name' => 'Report',
//                'route' => 'myReports',
//                'type' => 1,
//                'backend' => 0,
//            ]
//        );
//
//        DB::table('role_permission')->insert([
//            [
//                'permission_id' => $insertId,
//                'role_id' => '3',
//                'status' => 1,
//            ]
//        ]);


        Cache::forget('PermissionList');
        Cache::forget('RoleList');
        Cache::forget('PolicyPermissionList');
        Cache::forget('PolicyRoleList');
    }

    public function down()
    {
        //
    }
}
