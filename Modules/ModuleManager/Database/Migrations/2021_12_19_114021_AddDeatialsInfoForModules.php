<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\ModuleManager\Entities\Module;

class AddDeatialsInfoForModules extends Migration
{

    public function up()
    {

        Schema::table('modules', function($table){
            $table->text("details")->nullable()->change();
        });
//        DB::statement('ALTER TABLE `modules` CHANGE `details` `details` TEXT  NULL DEFAULT NULL;');
        $module = Module::where('name', 'AmazonS3')->first();
        if ($module) {
            $module->details = 'Amazon S3 is a service offered by Amazon Web Services that provides object storage through a web service interface. Amazon S3 Module Allow the to user add a lesson in Amazon S3 storage. After installing & active module, the user can find the Amazon S3 option as a host in add/edit lesson.';
            $module->save();
        }


        $module = Module::where('name', 'BBB')->first();
        if ($module) {
            $module->details = 'BigBlueButton (BBB) is a free software web conferencing system for Linux servers designed for online learning. Like Zoom, Users can create classes and take classes. After installing & active the BBB module, the user can find BBB as a host in Virtual Class.  Users can set their own BBB server configuration.';
            $module->save();
        }

        $module = Module::where('name', 'Jitsi')->first();
        if ($module) {
            $module->details = 'Jitsi is a collection of free and open-source multiplatform voice, video conferencing and instant messaging applications for the web platform, Windows, Linux, macOS, iOS and Android. Like Zoom/BBB,  Users can create rooms and take classes. After installing & active the Jitsi module, the user can find Jitsi as a host in Virtual Class.  Users can set their own Jitsi server/free Jitsi server.';
            $module->save();
        }


        $module = Module::where('name', 'Subscription')->first();
        if ($module) {
            $module->details = 'Subscription Module Allow to create & sell a subscription plan. Two types of subscription options in this module. one is "ALL Courses". Where  All course under subscription. Another subsection option is "Selected Courses".  Admin/Instructor can select courses under any subscription plan. ';
            $module->save();
        }

        $module = Module::where('name', 'SCORM')->first();
        if ($module) {
            $module->details = 'The SCORM module is a course activity that allows you (the teacher) to upload any SCORM  to include in your course. . After installing & active module, the user can find the SCORM option as a host in add/edit lesson.';
            $module->save();
        }


        $module = Module::where('name', 'Chat')->first();
        if ($module) {
            $module->details = 'Communication between Course Instructor, Admin, Student. Main feature is one to one chat, group chat, voice record, file send, pusher integration, block unblock, chat configuration.';
            $module->save();
        }

        $module = Module::where('name', 'Tax')->first();
        if ($module) {
            $module->details = 'Add Tax functionality in InfixLMS System. Admin can set tax percentage. Admin can Add country based tax percentage. When students buy any Item, the Tax will be applied. Tax can enable/disable/change anytime.';
            $module->save();
        }

        $module = Module::where('name', 'WhatsappSupport')->first();
        if ($module) {
            $module->details = 'WhatsApp Chat Support Module ready for InfixLS that will help you to option to Non-stop messaging with clients on your website. This is one of the best ways to connect and interact with your customers, you can offer support directly as well as build trust and increase customer loyalty';
            $module->save();
        }

        $module = Module::where('name', 'BundleSubscription')->first();
        if ($module) {
            $module->details = 'BundleSubscription modules allow creating a bundle. In bundle can add multiple courses/quizzes/classes. Admin/Instructors can create bundles. Admin/Instructors can set days. If set 0, then the bundle will never expire. But set days, then after student enrollment bundle will expire after selected days and students can not access. ';
            $module->save();
        }

        $module = Module::where('name', 'Assignment')->first();
        if ($module) {
            $module->details = 'The assignment module allows teachers to collect work from students, review it and provide feedback including grades. The work students submit is visible only to the teacher and not to the other students unless a group assignment is selected. Assignment settings.';
            $module->save();
        }
        $module = Module::where('name', 'Bkash')->first();
        if ($module) {
            $module->details = 'Bkash is a bangladeshi payment gateway. This module allow to get payment via Bkash';
            $module->save();
        }

        $module = Module::where('name', 'InstructorCertificate')->first();
        if ($module) {
            $module->details = 'InstructorCertificate module allows download students certificates of admin/instructor courses. Admin/instructor can understand how many students / who got the certificates from their Course.';
            $module->save();
        }

        $module = Module::where('name', 'TeachOffline')->first();
        if ($module) {
            $module->details = 'TeachOffline module allows import offline students and enrolls course to students. If the admin/instructor want to teach offline & track records then this module is useful for this purpose.';
            $module->save();
        }

        $module = Module::where('name', 'CourseOffer')->first();
        if ($module) {
            $module->details = 'CourseOffer module allows making an offer to students. Admin/instructors can create flat rates/percentage prices of selected courses. one dedicated page for the course offer. There all offered courses are listed. ';
            $module->save();
        }

        $module = Module::where('name', 'Org')->first();
        if ($module) {
            $module->details = 'Org (Organization) module allow creating an Organization. Admin can create a branch, position. Also can add material sources.';
            $module->save();
        }

        $module = Module::where('name', 'OrgInstructorPolicy')->first();
        if ($module) {
            $module->details = 'OrgInstructorPolicy module allows creating multiple group policies. Admin can assign role permissions & branches to group policy. Also can Assign instructors in group policy.';
            $module->save();
        }

        $module = Module::where('name', 'OrgSubscription')->first();
        if ($module) {
            $module->details = 'OrgSubscription module allows creating a plan. In this module, there is 2 type of plan. One is a class where the admin adds one course. And another is a learning path where the admin can add multiple courses/quizzes/classes. Also, can enrollment students & class/learning path. And showing enrollment history.';
            $module->save();
        }


    }


    public function down()
    {
        //
    }
}
