<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Appearance\Entities\Theme;
use Modules\CourseSetting\Entities\Category;
use Modules\FrontendManage\Entities\HeaderMenu;

class EdumeThemeSeeder extends Seeder
{

    public function run()
    {
        HeaderMenu::where('parent_id', 1)->delete();
        HeaderMenu::whereIn('id', [2, 3, 4])->update([
            'parent_id' => 5
        ]);

        UpdateHomeContent('key_feature_logo1', 'public/frontend/edume/img/lms_course/check.png');
        UpdateHomeContent('key_feature_logo2', 'public/frontend/edume/img/lms_course/check.png');
        UpdateHomeContent('key_feature_logo3', 'public/frontend/edume/img/lms_course/check.png');

        UpdateHomeContent('slider_banner', 'public/frontend/edume/img/banner/image.png');
        UpdateHomeContent('show_banner_subscription_box', 1);

        UpdateHomeContent('become_instructor_logo', 'public/frontend/edume/img/banner/become.png');
        UpdateHomeContent('become_instructor_title', 'Become an instructor brand on platform Infix!');
        UpdateHomeContent('become_instructor_sub_title', 'Unlimited access to world-class learning from your laptop tablet, or phone. Join over 15,000+ students');
        UpdateHomeContent('article_title', 'Resources & Insight');
        UpdateHomeContent('article_sub_title', 'You don’t need to be a designer or have any previous of experience with design to take follow classes. You just need curiosity and the desire to learn.');
//        UpdateHomeContent('article_title', '');


        DB::table('homepage_block_positions')->truncate();
        DB::statement("INSERT INTO `homepage_block_positions` (`id`, `block_name`, `order`, `created_at`, `updated_at`) VALUES
            (1, 'Homepage Banner', 0, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (2, 'Key Feature', 1, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (3, 'Category Section', 8, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (4, 'Instructor Section', 2, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (5, 'Course Section', 3, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (6, 'Best Category Section', 6, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (7, 'Quiz Section', 4, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (8, 'Testimonial Section', 7, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (9, 'Sponsor Section', 9, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (10, 'Article Section', 10, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (11, 'Become Instructor Section', 11, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (12, 'Subscribe Section', 12, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (13, 'Live Class', 5, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (14, 'About LMS', 14, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (15, 'Subscription Section', 15, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (16, 'How to buy', 13, '2021-12-19 11:36:00', '2021-12-19 11:36:00'),
            (17, 'Homepage FAQ', 14, '2021-12-19 11:36:01', '2021-12-19 11:36:01');");


        DB::table('sponsors')->truncate();
        DB::statement("INSERT INTO `sponsors` (`id`, `title`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'manter', 'public/frontend/edume/img/sponsors/1.png', 1, '2021-12-19 18:46:13', '2021-12-19 18:46:13'),
(2, 'wetransfer', 'public/frontend/edume/img/sponsors/2.png', 1, '2021-12-19 18:46:32', '2021-12-19 18:46:32'),
(3, 'oliver', 'public/frontend/edume/img/sponsors/3.png', 1, '2021-12-19 18:46:42', '2021-12-19 18:46:42'),
(4, 'manter2', 'public/frontend/edume/img/sponsors/4.png', 1, '2021-12-19 18:47:21', '2021-12-19 18:47:21'),
(5, 'oliver2', 'public/frontend/edume/img/sponsors/5.png', 1, '2021-12-19 18:47:56', '2021-12-19 18:47:56');");


        $categories = Category::whereNull('parent_id')->get();
        foreach ($categories as $key => $category) {
            if ($category->id == 5) {
                $category->status = 0;
            }
            $category->image = 'public/frontend/edume/img/lms_cat/' . ++$key . '.png';
            $category->save();
        }

    }
}
