<?php

use Illuminate\Database\Migrations\Migration;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\FrontendManage\Entities\WhyChoose;

class AddWhyChooseDemoData extends Migration
{
    public function up()
    {
        HomeContent::create([
            'key' => 'why_choose_title',
            'value' => 'Why Choose Infix LMS?',
        ]);

        HomeContent::create([
            'key' => 'why_choose_sub_title',
            'value' => 'Achieve better exam scores through quality contents tailored to helps learn effectively.',
        ]);

        HomeContent::create([
            'key' => 'show_continue_watching',
            'value' => '1',
        ]);

        HomeContent::create([
            'key' => 'show_popular_course',
            'value' => '1',
        ]);


        HomeContent::create([
            'key' => 'show_course_level',
            'value' => '1',
        ]);

        HomeContent::create([
            'key' => 'show_why_choose',
            'value' => '1',
        ]);

        WhyChoose::create([
            'title'=>'Customized Study Plans',
            'sub_title'=>'Diagnostic assessments to understand student’s abilities and provide personalized lesson plans',
            'image'=>'public/frontend/infixlmstheme/img/icon/icon_Customized_Study_plans.png',
        ]);

        WhyChoose::create([
            'title'=>'Subjects On Demand',
            'sub_title'=>'Add on any subjects at any time on your package.',
            'image'=>'public/frontend/infixlmstheme/img/icon/icon_Subjects_On_Demand.png',
        ]);


        WhyChoose::create([
            'title'=>'Parental Engagement',
            'sub_title'=>'Parents are given constructive feedback from tutors after each lesson',
            'image'=>'public/frontend/infixlmstheme/img/icon/icon_Parental_Engagement.png',
        ]);

        WhyChoose::create([
            'title'=>'Live & Interactive Learning',
            'sub_title'=>'Diagnostic assessments to understand student’s abilities and provide personalized lesson plans.',
            'image'=>'public/frontend/infixlmstheme/img/icon/icon_Live_and_Interactive_Learning.png',
        ]);

        WhyChoose::create([
            'title'=>'Outstanding Tutors and Guaranteed Results',
            'sub_title'=>'Add on any subjects at any time on your package',
            'image'=>'public/frontend/infixlmstheme/img/icon/icon_Outstanding_Tutors_and_Guaranteed_Results.png',
        ]);

        WhyChoose::create([
            'title'=>'Parental Engagement',
            'sub_title'=>'Parents are given constructive feedback from tutors after each lesson',
            'image'=>'public/frontend/infixlmstheme/img/icon/icon_Parental_Engagement_2.png',
        ]);
    }

    public function down()
    {
        //
    }
}
