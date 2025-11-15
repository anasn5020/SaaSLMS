<?php

namespace Modules\FrontendManage\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\FrontendManage\Entities\HomePageFaq;
use Modules\FrontendManage\Entities\Slider;

class FrontendManageDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(BecomeInstructorTableSeeder::class);
        $this->call(SponsorTableSeeder::class);
        $this->call(WorkProcessTableSeeder::class);

        $sliders = [
            [
                'title' => 'For every student, every classroom. Real results.',
                'sub_title' => 'Build skills with courses, certificates, and degrees online from world-class universities and companies',
                'image' => 'public/demo/slider/1.jpg',
                'btn_title1' => 'Courses',
                'btn_link1' => '#',
                'btn_type1' => 1,
                'btn_type2' => 1,
                'btn_title2' => 'Classes',
                'btn_link2' => '#',
            ], [
                'title' => 'For every student, every classroom. Real results.',
                'sub_title' => 'Build skills with courses, certificates, and degrees online from world-class universities and companies',
                'image' => 'public/demo/slider/2.jpg',
                'btn_title1' => 'Courses',
                'btn_link1' => '#',
                'btn_type1' => 1,
                'btn_type2' => 1,
                'btn_title2' => 'Classes',
                'btn_link2' => '#',
            ],
        ];
        Slider::insert($sliders);

        $faqs = [
            [
                'question' => 'What is an LMS?',
                'answer' => 'An LMS, or Learning Management System, is a software application designed to administer, track, and manage educational content and resources. It is commonly used in educational institutions and organizations for online learning and training.',
            ],
            [
                'question' => 'How does an LMS work?',
                'answer' => 'An LMS works by providing a centralized platform for creating, delivering, and managing learning content. It typically includes features for course creation, user management, assessment tools, and reporting.',
            ], [
                'question' => 'What are the key features of an LMS?',
                'answer' => 'Key features of an LMS include course creation and management, user enrollment and tracking, assessment and grading tools, collaboration features, reporting and analytics, and integration capabilities with other systems.',
            ], [
                'question' => 'Who can benefit from using an LMS?',
                'answer' => 'LMSs are beneficial for educational institutions, corporate training programs, and any organization that wants to deliver and manage training and learning materials efficiently.',
            ], [
                'question' => 'What types of content can be delivered through an LMS?',
                'answer' => 'LMSs support a variety of content types, including text-based materials, videos, interactive quizzes, assignments, and more. They can accommodate a range of learning styles and formats.',
            ]
        ];

        HomePageFaq::insert($faqs);
    }
}
