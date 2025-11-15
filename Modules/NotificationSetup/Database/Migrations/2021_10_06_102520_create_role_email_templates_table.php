<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\NotificationSetup\Entities\RoleEmailTemplate;

class CreateRoleEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_email_templates', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id');
            $table->string('template_act');
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        RoleEmailTemplate::insert([
            [
                'role_id' => 1,
                'template_act' => 'OffLine_Payment'
            ],
            [
                'role_id' => 1,
                'template_act' => 'Bank_Payment'
            ], [
                'role_id' => 1,
                'template_act' => 'Course_Enroll_Payment'
            ], [
                'role_id' => 1,
                'template_act' => 'Course_Publish_Successfully'
            ], [
                'role_id' => 1,
                'template_act' => 'Course_Unpublished'
            ], [
                'role_id' => 1,
                'template_act' => 'Enroll_notify_Instructor'
            ], [
                'role_id' => 1,
                'template_act' => 'Course_comment'
            ], [
                'role_id' => 1,
                'template_act' => 'Course_comment_Reply'
            ], [
                'role_id' => 1,
                'template_act' => 'Course_Review'
            ], [
                'role_id' => 1,
                'template_act' => 'Reset_Password'
            ], [
                'role_id' => 1,
                'template_act' => 'Course_Assignment_Added'
            ], [
                'role_id' => 1,
                'template_act' => 'Student_Submit_Assignment'
            ], [
                'role_id' => 1,
                'template_act' => 'Student_Submit_Homework'
            ], [
                'role_id' => 2,
                'template_act' => 'OffLine_Payment'
            ], [
                'role_id' => 2,
                'template_act' => 'OffLine_Payment'
            ], [
                'role_id' => 2,
                'template_act' => 'Bank_Payment'
            ], [
                'role_id' => 2,
                'template_act' => 'Course_Enroll_Payment'
            ], [
                'role_id' => 2,
                'template_act' => 'Course_Publish_Successfully'
            ], [
                'role_id' => 2,
                'template_act' => 'Course_Unpublished'
            ], [
                'role_id' => 2,
                'template_act' => 'Enroll_notify_Instructor'
            ], [
                'role_id' => 2,
                'template_act' => 'Course_comment'
            ], [
                'role_id' => 2,
                'template_act' => 'Course_comment_Reply'
            ], [
                'role_id' => 2,
                'template_act' => 'Course_Review'
            ], [
                'role_id' => 2,
                'template_act' => 'Email_Verification'
            ], [
                'role_id' => 2,
                'template_act' => 'Enroll_Rejected'
            ], [
                'role_id' => 2,
                'template_act' => 'Enroll_Enabled'
            ], [
                'role_id' => 2,
                'template_act' => 'Reset_Password'
            ], [
                'role_id' => 2,
                'template_act' => 'Offline_Enrolled'
            ], [
                'role_id' => 2,
                'template_act' => 'Course_Assignment_Added'
            ], [
                'role_id' => 2,
                'template_act' => 'Student_Submit_Assignment'
            ], [
                'role_id' => 2,
                'template_act' => 'Student_Submit_Homework'
            ], [
                'role_id' => 2,
                'template_act' => 'Communicate_Email'
            ], [
                'role_id' => 3,
                'template_act' => 'OffLine_Payment'
            ], [
                'role_id' => 3,
                'template_act' => 'Bank_Payment'
            ], [
                'role_id' => 3,
                'template_act' => 'Course_Enroll_Payment'
            ], [
                'role_id' => 3,
                'template_act' => 'Course_Publish_Successfully'
            ], [
                'role_id' => 3,
                'template_act' => 'Course_Chapter_Added'
            ], [
                'role_id' => 3,
                'template_act' => 'Course_Lesson_Added'
            ], [
                'role_id' => 3,
                'template_act' => 'Course_Quiz_Added'
            ], [
                'role_id' => 3,
                'template_act' => 'Course_ExerciseFile_Added'
            ], [
                'role_id' => 3,
                'template_act' => 'Course_comment_Reply'
            ], [
                'role_id' => 3,
                'template_act' => 'Email_Verification'
            ], [
                'role_id' => 3,
                'template_act' => 'Enroll_Rejected'
            ], [
                'role_id' => 3,
                'template_act' => 'Enroll_Enabled'
            ], [
                'role_id' => 3,
                'template_act' => 'Reset_Password'
            ], [
                'role_id' => 3,
                'template_act' => 'Offline_Enrolled'
            ], [
                'role_id' => 3,
                'template_act' => 'Course_Assignment_Added'
            ], [
                'role_id' => 3,
                'template_act' => 'Teacher_Marked_Assignment'
            ], [
                'role_id' => 3,
                'template_act' => 'Teacher_Marked_Homework'
            ], [
                'role_id' => 3,
                'template_act' => 'Student_Certificate_Generate'
            ], [
                'role_id' => 3,
                'template_act' => 'Communicate_Email'
            ], [
                'role_id' => 4,
                'template_act' => 'OffLine_Payment'
            ], [
                'role_id' => 4,
                'template_act' => 'Bank_Payment'
            ], [
                'role_id' => 4,
                'template_act' => 'Course_Enroll_Payment'
            ], [
                'role_id' => 4,
                'template_act' => 'Course_Publish_Successfully'
            ], [
                'role_id' => 4,
                'template_act' => 'Course_Unpublished'
            ], [
                'role_id' => 4,
                'template_act' => 'Enroll_notify_Instructor'
            ], [
                'role_id' => 4,
                'template_act' => 'Course_comment'
            ], [
                'role_id' => 4,
                'template_act' => 'Course_comment_Reply'
            ], [
                'role_id' => 4,
                'template_act' => 'Course_Review'
            ], [
                'role_id' => 4,
                'template_act' => 'Reset_Password'
            ], [
                'role_id' => 4,
                'template_act' => 'Student_Submit_Assignment'
            ], [
                'role_id' => 4,
                'template_act' => 'Course_Assignment_Added'
            ], [
                'role_id' => 4,
                'template_act' => 'Student_Submit_Assignment'
            ], [
                'role_id' => 4,
                'template_act' => 'Student_Submit_Homework'
            ], [
                'role_id' => 4,
                'template_act' => 'Communicate_Email'
            ], [
                'role_id' => 4,
                'template_act' => 'Course_Invitation'
            ]
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_email_templates');
    }
}
