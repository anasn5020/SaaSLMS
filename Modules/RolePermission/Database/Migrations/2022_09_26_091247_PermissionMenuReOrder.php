<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\Permission;

class PermissionMenuReOrder extends Migration
{
    public function up()
    {
        if (config('database.default') == 'pgsql') {
            $id = Permission::max('id');
            DB::statement("ALTER SEQUENCE permissions_id_seq RESTART WITH " . ++$id);
        }
        Permission::whereNotNull('module_id')->update(['module_id' => null]);
        Permission::whereNotNull('parent_id')->update(['parent_id' => null]);

        $deleted_route = [
            'zoom.meetings',
            'bbb.meetings',
            'footerEmailConfig',
            'virtual-class.setting'
        ];
        Permission::whereIn('route', $deleted_route)->delete();

        $addModules = [
            [
                'route' => 'org.branch',
                'module' => 'Org'
            ], [
                'route' => 'org.position',
                'module' => 'Org'
            ], [
                'route' => 'communicate',
                'module' => 'Communicate'
            ], [
                'route' => 'Event',
                'module' => 'Event'
            ], [
                'route' => 'bbb',
                'module' => 'BBB'
            ], [
                'route' => 'bbb.meetings.index',
                'module' => 'BBB'
            ], [
                'route' => 'bbb.settings',
                'module' => 'BBB'
            ],
        ];

        foreach ($addModules as $item) {
            $menu = Permission::where('route', $item['route'])->first();
            if ($menu) {
                $menu->module = $item['module'];
                $menu->save();
            }
        }


        $quiz_list = Permission::where('route', 'question-bank-list')->first();
        if (!$quiz_list) {
            $quiz_list = new Permission();
        }
        $quiz_list->name = 'Question Bank';
        $quiz_list->route = 'question-bank-list';
        $quiz_list->type = 2;
        $quiz_list->parent_route = 'quiz';
        $quiz_list->save();


        $demo = Permission::where('route', 'appearance.themes.demo')->first();
        if (!$demo) {
            $demo = new Permission();
        }
        $demo->name = 'Import Demo Data';
        $demo->route = 'appearance.themes.demo';
        $demo->type = 2;
        $demo->parent_route = 'appearance';
        $demo->save();


        $item = Permission::where('route', 'coupons.inviteSettings')->first();
        if ($item) {
            $item->type = 1;
            $item->parent_route = null;
            $item->save();
        }

        $item = Permission::where('route', 'quizResult')->first();
        if ($item) {
            $item->parent_route = 'quiz';
            $item->save();
        }

        $item = Permission::where('route', 'headermenu')->first();
        if ($item) {
            $item->route = 'frontend.headermenu';
            $item->parent_route = 'frontend_CMS';
            $item->save();
        }


        $item = Permission::where('route', 'setting.updateSystem')->first();
        if ($item) {
            $item->name = 'About & Update';
            $item->save();
        }

        $item = Permission::where('route', 'frontend.page.index')->first();
        if ($item) {
            $item->name = 'Aora PageBuilder';
            $item->save();
        }

        $item = Permission::where('route', 'frontend.sliders')->first();
        if ($item) {
            $item->route = 'frontend.sliders.index';
            $item->save();
        }
        $item = Permission::where('route', 'pageContent')->first();
        if ($item) {
            $item->route = 'frontend.pageContent';
            $item->save();
        }
        $item = Permission::where('route', 'loginpage.index')->first();
        if ($item) {
            $item->route = 'frontend.loginpage.index';
            $item->save();
        }

        $orders = [
            'dashboard',
            'students',
            'student.student_list',
            'regular_student_import',
            'student.new_enroll',
            'student.student_field',
            'admin.enrollLogs',
            'admin.cancelLogs',
            'instructors',
            'allInstructor',
            'admin.instructor.payout',
            'courses',
            'course.category',
            'getAllCourse',
            'course.setting',
            'quiz',
            'question-group',
            'question-bank-list',
            'question-bank-bulk',
            'online-quiz',
            'quizSetup',
            'coupons',
            'coupons.manage',
            'coupons.common',
            'coupons.single',
            'coupons.personalized',
            'coupons.invite_code',
            'coupons.inviteSettings',
            'communications',
            'communication.PrivateMessage',
            'payments',
            'onlineLog',
            'offlinePayment',
            'bankPayment.index',
            'reports',
            'admin.reveuneList',
            'admin.reveuneListInstructor',
            'course.courseStatistics',
            'quizResult',
            'certificate',
            'certificate.index',
            'certificate.create',
            'certificate.fonts',
            'frontend_CMS',
            'headermenu',
            'frontend.menusetting',
            'frontend.sliders.index',
            'frontend.sliders.setting',
            'frontend.homeContent',
            'frontend.pageContent',
            'frontend.privacy_policy',
            'frontend.testimonials',
            'frontend.socialSetting',
            'frontend.AboutPage',
            'frontend.ContactPageContent',
            'frontend.page.index',
            'frontend.becomeInstructor',
            'frontend.sponsors.index',
            'popup-content.index',
            'footerSetting.footer.index',
            'frontend.loginpage.index',
            'frontend.faq.index',
            'zoom',
            'zoom.settings',
            'virtual-class',
            'virtual-class.index',
            'blogs',
            'blog-category.index',
            'blogs.index',
            'newsletter',
            'newsletter.setting',
            'newsletter.mailchimp.setting',
            'newsletter.getresponse.setting',
            'newsletter.acelle.setting',
            'newsletter.subscriber',
            'appearance',
            'appearance.themes.index',
            'appearance.themes.demo',
            'appearance.themes-customize.index',
            'notification',
            'notification_setup_list',
            'UserNotificationControll',
            'setting.pushNotification',
            'utility',
            'setting.preloader',
            'setting.error_log',
            'user.manager',
            'staffs.index',
            'hr.department.index',
            'permission.roles.index',
            'staffs.settings',
            'settings',
            'setting.activation',
            'setting.general_settings',
            'setting.setCommission',
            'settings.instructor_setup',
            'setting.email_setup',
            'EmailTemp',
            'paymentmethodsetting.payment_method_setting',
            'api.setting',
            'vimeosetting.index',
            'vdocipher.setting',
            'gdrive.setting',
            'setting.seo_setting',
            'languages.index',
            'currencies.index',
            'timezone.index',
            'modulemanager.index',
            'setting.updateSystem',
            'city.index',
            'setting.cookieSetting',
            'setting.cacheSetting',
            'setting.queueSetting',
            'setting.cronJob',
            'setting.captcha',
            'setting.socialLogin',
            'sidebar-manager.index',
            'backup.index',
        ];


        foreach ($orders as $key => $item) {
            $menu = Permission::where('route', $item)->first();
            if ($menu) {
                $menu->position = $key + 1;
                $menu->save();
            }
        }

        $actions = [
            'backup.create',
            'backup.delete',
            'backup.import'
        ];
        Permission::whereIn('route', $actions)
            ->update([
                'type' => 3
            ]);

        $enrollmentCancellation = Permission::where('route', 'enrollmentCancellation')->first();
        if ($enrollmentCancellation) {
            $enrollmentCancellation->position = 99999 + 1;
            $enrollmentCancellation->save();
        }

        $details = Permission::where('route', 'course.details')->first();
        if ($details) {
            $details->route = 'courseDetails';
            $details->save();
        }

        $utitltiesOrder = [
            'setting.maintenance',
            'setting.utilities',
            'ipBlock.index',
            'setting.geoLocation'
        ];
        Permission::whereIn('route', $utitltiesOrder)
            ->update([
                'parent_route' => 'utility'
            ]);

        Permission::where('route', 'permission.roles.index')
            ->update([
                'parent_route' => 'user.manager'
            ]);

        $frontends = [
            'headermenu',
            'headermenu.add-element',
            'headermenu.edit-element',
            'headermenu.reordering',
            'headermenu.delete'
        ];
        foreach ($frontends as $frontend) {
            Permission::where('route', $frontend)
                ->update([
                    'route' => 'frontend.' . $frontend
                ]);
        }

    }

    public function down()
    {
        //
    }
}
