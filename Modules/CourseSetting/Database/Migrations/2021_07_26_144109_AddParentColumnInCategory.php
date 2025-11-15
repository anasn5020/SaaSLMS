<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Coupons\Entities\UserWiseCoupon;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\SubCategory;

class AddParentColumnInCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('categories', function ($table) {
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->integer('parent_id',)->nullable();;
            }
        });

        $subs = SubCategory::all();
        foreach ($subs as $sub) {
            $cat = Category::where('name', $sub->name)->first();
            if (!$cat) {
                $cat = new Category();
                $cat->name = $sub->name;
                $cat->status = $sub->status;
                $cat->title = $sub->name;
                $cat->description = $sub->name;
                $cat->url = '';
                $cat->show_home = $sub->show_home;
                $cat->position_order = $sub->position_order;
                $cat->image = 'public/demo/category/image/1.svg';
                $cat->thumbnail = 'public/demo/category/thumb/1.svg';
                $cat->parent_id = $sub->category_id;
                $cat->save();
            }


            $courses = \Modules\CourseSetting\Entities\Course::where('subcategory_id', $sub->id)->get();
            foreach ($courses as $course) {
                $course->subcategory_id = $cat->id;
                $course->save();
            }

            $quizzes = \Modules\Quiz\Entities\OnlineQuiz::where('sub_category_id', $sub->id)->get();
            foreach ($quizzes as $quiz) {
                $quiz->sub_category_id = $cat->id;
                $quiz->save();
            }

            $coupons = \Modules\Coupons\Entities\Coupon::where('subcategory_id', $sub->id)->get();
            foreach ($coupons as $coupon) {
                $coupon->subcategory_id = $cat->id;
                $coupon->save();
            }

            $qus = \Modules\Quiz\Entities\QuestionBank::where('sub_category_id', $sub->id)->get();
            foreach ($qus as $q) {
                $q->sub_category_id = $cat->id;
                $q->save();
            }

            $classes = \Modules\VirtualClass\Entities\VirtualClass::where('sub_category_id', $sub->id)->get();
            foreach ($classes as $class) {
                $class->sub_category_id = $cat->id;
                $class->save();
            }

            $coupons = UserWiseCoupon::where('subcategory_id', $sub->id)->get();
            foreach ($coupons as $coupon) {
                $coupon->subcategory_id = $cat->id;
                $coupon->save();
            }

        }
        Schema::enableForeignKeyConstraints();
        Cache::forget('categories');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
