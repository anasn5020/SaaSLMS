<?php

namespace Modules\CourseSetting\Database\Seeders;

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\CourseSetting\Entities\Category;

class CategorySeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $categories = [
            [
                'name' => 'Business',
                'title' => 'Business',
                'description' => 'Explore courses and resources to enhance your business acumen and entrepreneurial skills.',
                'position_order' => 2,
                'image' => 'public/demo/category/image/1.svg',
                'thumbnail' => 'public/demo/category/thumb/1.png',
                'url' => 'https://youtu.be/bG9eMa_025c',
            ],
            [
                'name' => '3D Modeling',
                'title' => '3D Modeling',
                'description' => 'Learn the art of creating three-dimensional models and environments with industry-standard software.',
                'position_order' => 2,
                'image' => 'public/demo/category/image/2.svg',
                'thumbnail' => 'public/demo/category/thumb/2.png',
                'url' => 'https://youtu.be/bG9eMa_025c',
            ],
            [
                'name' => 'UI UX Design',
                'title' => 'UI UX Design',
                'description' => 'Master the principles of User Interface (UI) and User Experience (UX) design for creating intuitive digital experiences.',
                'position_order' => 3,
                'image' => 'public/demo/category/image/3.svg',
                'thumbnail' => 'public/demo/category/thumb/3.png',
                'url' => 'https://youtu.be/bG9eMa_025c',
            ],
            [
                'name' => 'Mobile Development',
                'title' => 'Mobile Development',
                'description' => 'Build mobile applications for Android and iOS platforms with industry-leading tools and frameworks.',
                'position_order' => 4,
                'image' => 'public/demo/category/image/4.svg',
                'thumbnail' => 'public/demo/category/thumb/4.png',
                'url' => 'https://youtu.be/bG9eMa_025c',
            ],
            [
                'name' => 'Software Development',
                'title' => 'Software Development',
                'description' => 'Enhance your programming skills and learn software development best practices to create robust applications.',
                'position_order' => 5,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => 'https://youtu.be/bG9eMa_025c',
            ],
            [
                'name' => 'Accounting',
                'title' => 'Accounting',
                'description' => 'Master the principles of financial accounting, auditing, and taxation for a successful career in accounting.',
                'position_order' => 1,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 1,
            ],
            [
                'name' => 'MBA',
                'title' => 'MBA',
                'description' => 'Pursue an MBA and gain expertise in management, leadership, finance, marketing, and strategic planning.',
                'position_order' => 1,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 1,
            ],
            [
                'name' => 'Blender Creator',
                'title' => 'Blender Creator',
                'description' => 'Learn Blender, a powerful open-source 3D modeling and animation software, for creating stunning visual content.',
                'position_order' => 3,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 2,
            ],
            [
                'name' => '3D Environments',
                'title' => '3D Environments',
                'description' => 'Design realistic 3D environments using industry-standard tools and techniques.',
                'position_order' => 3,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 2,
            ],
            [
                'name' => 'Adobe XD',
                'title' => 'Adobe XD',
                'description' => 'Master Adobe XD for designing intuitive user interfaces and interactive prototypes for web and mobile applications.',
                'position_order' => 5,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 3,
            ],
            [
                'name' => 'UI Design',
                'title' => 'UI Design',
                'description' => 'Learn the fundamentals of UI design, including layout, typography, color theory, and usability principles.',
                'position_order' => 6,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 3,
            ],
            [
                'name' => 'App Development',
                'title' => 'App Development',
                'description' => 'Build cross-platform mobile applications with frameworks like React Native and Flutter for Android and iOS.',
                'position_order' => 7,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 4,
            ],
            [
                'name' => 'Python',
                'title' => 'Python',
                'description' => 'Learn Python programming language for web development, data analysis, machine learning, and automation.',
                'position_order' => 8,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 5,
            ],
            [
                'name' => 'iOS Development',
                'title' => 'iOS Development',
                'description' => 'Master iOS app development using Swift and Xcode to create powerful and user-friendly applications.',
                'position_order' => 8,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 5,
            ],
            [
                'name' => 'Laravel',
                'title' => 'Laravel',
                'description' => 'Build scalable web applications using Laravel, a PHP framework known for its elegant syntax and robust features.',
                'position_order' => 8,
                'image' => 'public/demo/category/image/5.svg',
                'thumbnail' => 'public/demo/category/thumb/5.png',
                'url' => '',
                'parent_id' => 5,
            ],
        ];


        //foreach by categories items
        foreach ($categories as $category){
            Category::create([
                'name' => $category['name']??'',
                'title' => $category['title']??'',
                'description' => $category['description']??'',
                'position_order' => $category['position_order']??0,
                'image' => $category['image']??"",
                'thumbnail' => $category['thumbnail']??"",
                'url' => $category['url']??'',
                'parent_id' => $category['parent_id']??null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'show_home' =>1,

            ]);
        }
    }
}
