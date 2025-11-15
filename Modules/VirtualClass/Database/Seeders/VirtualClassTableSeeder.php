<?php

namespace Modules\VirtualClass\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Modules\CourseSetting\Entities\Course;
use Modules\VirtualClass\Entities\VirtualClass;
use Modules\VirtualClass\Http\Controllers\CustomMeetingController;
use Modules\VirtualClass\Http\Controllers\VirtualClassController;

class VirtualClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $virtualClassController = new VirtualClassController();


        $classes =[
            [
                'title' => 'Online Class for Mastering in Laravel',
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 1,
                'user_id' => 1,
                'about' => 'Become proficient in Laravel framework through this comprehensive online class. Learn to build robust web applications using Laravel and its powerful features',
                'image' => 'public/frontend/infixlmstheme/img/class/1.jpg'
            ],
            [
                'title' => 'Online Class for Mastering in Accounting',
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' => "Master accounting principles and practices through this online class. Learn essential accounting concepts, financial statements, and reporting.",
                'image' => 'public/frontend/infixlmstheme/img/class/2.jpg'
            ],

            [
                'title' => "Online Class for Mastering in PHP",
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' =>"Deepen your PHP skills with this online class. Explore advanced PHP techniques, web application development, and server-side scripting.",
                'image' => 'public/frontend/infixlmstheme/img/class/3.jpg'
            ],

            [
                'title' => "Online Class for Mastering in jQuery",
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' =>"Master jQuery framework with this comprehensive online class. Learn to enhance web pages, handle events, and create dynamic effects with ease.",
                'image' => 'public/frontend/infixlmstheme/img/class/4.jpg'
            ],

            [
                'title' =>  "Online Class for Mastering in HTML",
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' =>"Learn HTML fundamentals and advanced techniques in this online class. Master HTML5, create web pages, and understand semantic markup.",
                'image' => 'public/frontend/infixlmstheme/img/class/5.jpg'
            ],


            [
                'title' =>  "Online Class for Mastering in CSS",
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' =>"Deep dive into CSS with this online class. Learn advanced styling techniques, CSS3 features, and responsive design principles.",
                'image' => 'public/frontend/infixlmstheme/img/class/6.jpg'
            ],

            [
                'title' =>  "Online Class for Mastering in MySQL",
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' =>"Master MySQL database management with this online class. Learn SQL queries, database design, and optimize database performance.",
                'image' => 'public/frontend/infixlmstheme/img/class/7.jpg'
            ],

            [
                'title' => "Online Class for Mastering in ASP.Net",
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' =>"Explore ASP.NET framework with this online class. Learn web application development, server-side scripting, and MVC architecture.",
                'image' => 'public/frontend/infixlmstheme/img/class/8.jpg'
            ],


            [
                'title' => "Online Class for Mastering in Python",
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' =>"Dive into Python programming with this online class. Learn Python fundamentals, data structures, and develop real-world applications.",
                'image' => 'public/frontend/infixlmstheme/img/class/9.jpg'
            ],
            [
                'title' => "Online Class for Mastering in Photoshop",
                'price' => rand(10, 100),
                'duration' => rand(30, 60),
                'category_id' => 1,
                'sub_category_id' => 1,
                'type' => 0,
                'host' => 'Custom',
                'lang_id' => 19,
                'is_recurring' => 0,
                'recurring_type' => 0,
                'recurring_repeat_count' => 0,
                'recurring_days' => json_encode([]),
                'start_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'end_date' => Carbon::now()->format(getActivePhpDateFormat()),
                'time' => '06:00 PM',
                'scope' => 1,
                'level' => 2,
                'user_id' => 1,
                'about' =>"Master Adobe Photoshop with this online class. Learn image editing, digital graphics, and design techniques.",
                'image' => 'public/frontend/infixlmstheme/img/class/10.jpg'
            ],

        ];
        foreach ($classes as $class) {
            $totalClass =rand(1,10);
            $newClass = VirtualClass::create([
                'title' => $class['title'] ?? '',
                'fees' => $class['price'] ?? 0,
                'duration' => $class['duration'] ?? 0,
                'category_id' => $class['category_id'] ?? 0,
                'sub_category_id' => $class['sub_category_id'] ?? 0,
                'type' => $class['type'] ?? 0,
                'host' => $class['host'] ?? 'Custom',
                'lang_id' => $class['lang_id'] ?? 19,
                'capacity' => $class['capacity'] ?? 0,
                'is_recurring' => 1,
                'recurring_type' => 1,
                'recurring_repeat_count' => $class['recurring_repeat_count'] ?? 0,
                'recurring_days' => $class['recurring_days'] ?? [],
                'start_date' => Carbon::createFromFormat(getActivePhpDateFormat(), $class['start_date'])->format('Y-m-d'),
                'end_date' => Carbon::createFromFormat(getActivePhpDateFormat(), $class['end_date'])->addDays($totalClass)->format('Y-m-d'),
                'time' => $class['time'] ?? '',
                'total_class' => $totalClass,
            ]);

            $startDate =Carbon::parse($newClass->start_date);
            $endDate= Carbon::parse($newClass->end_date);
            $currentDate = $startDate->copy();
            $days =[];
            while ($currentDate <= $endDate) {
                $days[] = $currentDate->toDateString();
                $currentDate->addDay();
            }

            Course::create([
                'title' => $class['title'] ?? '',
                'about' => $class['about'] ?? '',
                'class_id' => $newClass->id,
                'user_id' => $class['user_id'] ?? 0,
                'lang_id' => $class['lang_id'] ?? 19,
                'price' => $class['price'] ?? 0,
                'type' => 3,
                'scope' => $class['scope'] ?? 0,
                'level' => $class['level'] ?? 0,
                'image' => $class['image'] ?? '',
                'thumbnail' => $class['image'] ?? '',
            ]);
            foreach ($days as $day){
                $new_date = Carbon::createFromFormat('Y-m-d', $day)->format('m/d/Y');

                $data['topic'] = $class['title'] ?? 0;
                $data['description'] = $class['about'] ?? 0;
                $data['duration'] = $class['duration'] ?? 0;
                $data['instructor_id'] = $class['user_id'] ?? 0;
                $data['class_id'] = $newClass->id;
                $data['date'] = $new_date;
                $data['time'] = $newClass->time;

                $meeting = new CustomMeetingController();
                $meeting->classStore($data);
            }
        }
    }
}
