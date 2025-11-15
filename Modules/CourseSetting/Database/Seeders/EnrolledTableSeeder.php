<?php

namespace Modules\CourseSetting\Database\Seeders;

use App\BillingDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Payment\Entities\Checkout;

class EnrolledTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        for ($i = 1; $i <= 7; $i++) {
//            CourseEnrolled::insert([
//                'user_id' => 3,
//                'course_id' => $i,
//                'purchase_price' => $i + 20,
//                'coupon' => 'Vel',
//                'discount_amount' => 10,
//                'status' => 1,
//                'reveune' => 2,
//                'created_at' => now(),
//                'updated_at' => now()
//            ]);
//        }

        Checkout::insert([
            [
                'tracking' => 'K3USKPJBC5U8',
                'user_id' => 3,
                'purchase_price' => 0.00,
                'price' => 0.00,
                'billing_detail_id' => 1,
                'payment_method' => 'None'
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'purchase_price' => 100.00,
                'price' => 100.00,
                'billing_detail_id' => 1,
                'payment_method' => 'None'
            ], [
                'tracking' => '765A3UJ7B11M',
                'user_id' => 3,
                'purchase_price' => 0.00,
                'price' => 0.00,
                'billing_detail_id' => 2,
                'payment_method' => 'None'
            ],
        ]);

        BillingDetails::insert([
            [
                'tracking_id' => 'K3USKPJBC5U8',
                'user_id' => 3,
                'first_name' => 'Student',
                'last_name' => '',
                'company_name' => 'AoraSoft',
                'country' => 19,
                'address1' => 'Dhaka',
                'address2' => '',
                'city' => 'Dhaka',
                'zip_code' => '1200',
                'phone' => '01723442233',
                'email' => 'student@infixlms.com',
                'details' => 'add here additional info'
            ], [
                'tracking_id' => '765A3UJ7B11M',
                'user_id' => 3,
                'first_name' => 'Student',
                'last_name' => '',
                'company_name' => 'AoraSoft',
                'country' => 19,
                'address1' => 'Dhaka',
                'address2' => '',
                'city' => 'Dhaka',
                'zip_code' => '1200',
                'phone' => '01723442233',
                'email' => 'student@infixlms.com',
                'details' => 'add here additional info'
            ],
        ]);

//        DB::statement("INSERT INTO `checkouts` (`id`, `tracking`, `user_id`, `billing_detail_id`, `package_id`, `coupon_id`, `discount`, `purchase_price`, `price`, `status`, `payment_method`, `response`, `created_at`, `updated_at`) VALUES
//(1, 'K3USKPJBC5U8', 3, 1, NULL, NULL, 0.00, 0.00, 0.00, 1, 'None', NULL, now(),now()),
//(2, '765A3UJ7B4ZM', 3, 1, NULL, NULL, 0.00, 100.00, 100.00, 1, 'None', NULL, now(), now()),
//(3, '765A3UJ7B11M', 3, 2, NULL, NULL, 0.00, 0.00, 0.00, 1, 'None', NULL, now(), now());
//");

        CourseEnrolled::insert([
            [
                'tracking' => 'K3USKPJBC5U8',
                'user_id' => 3,
                'course_id' => 1,
                'purchase_price' => 0.00,
                'coupon' => null,
                'discount_amount' => 0.00,
                'status' => 1,
                'reveune' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'course_id' => 2,
                'purchase_price' => 20.00,
                'coupon' => null,
                'discount_amount' => 10.00,
                'reveune' => 2.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'course_id' => 3,
                'purchase_price' => 20.00,
                'coupon' => null,
                'discount_amount' => 10.00,
                'reveune' => 2.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'course_id' => 4,
                'purchase_price' => 20.00,
                'coupon' => null,
                'discount_amount' => 10.00,
                'reveune' => 2.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'course_id' => 5,
                'purchase_price' => 20.00,
                'coupon' => null,
                'discount_amount' => 10.00,
                'reveune' => 2.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'course_id' => 6,
                'purchase_price' => 20.00,
                'coupon' => null,
                'discount_amount' => 10.00,
                'reveune' => 2.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'course_id' => 12,
                'purchase_price' => 0.00,
                'coupon' => null,
                'discount_amount' => 0.00,
                'reveune' => 0.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'course_id' => 13,
                'purchase_price' => 0.00,
                'coupon' => null,
                'discount_amount' => 0.00,
                'reveune' => 0.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'tracking' => '765A3UJ7B4ZM',
                'user_id' => 3,
                'course_id' => 14,
                'purchase_price' => 0.00,
                'coupon' => null,
                'discount_amount' => 0.00,
                'reveune' => 0.00,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

//        DB::statement("INSERT INTO `course_enrolleds` ( `tracking`, `user_id`, `course_id`, `purchase_price`, `coupon`, `discount_amount`, `status`, `reveune`, `reason`, `created_at`, `updated_at`) VALUES
//( 'K3USKPJBC5U8', 3, 1, 0.00, NULL, 0.00, 1, 0.00, NULL,now(), now()),
//( '765A3UJ7B4ZM', 3, 2, 20.00, NULL, 10.00, 1, 2.00, NULL, now(),now()),
//( '765A3UJ7B4ZM', 3, 3, 20.00, NULL, 10.00, 1, 2.00, NULL, now(),now()),
//( '765A3UJ7B4ZM', 3, 4, 20.00, NULL, 10.00, 1, 2.00, NULL, now(),now()),
//( '765A3UJ7B4ZM', 3, 5, 20.00, NULL, 10.00, 1, 2.00, NULL, now(),now()),
//( '765A3UJ7B4ZM', 3, 6, 20.00, NULL, 10.00, 1, 2.00, NULL, now(),now()),
//( '765A3UJ7B11M', 3, 12, 0.00, NULL, 0.00, 1, 0.00, NULL, now(),now()),
//( '765A3UJ7B11M', 3, 13, 0.00, NULL, 0.00, 1, 0.00, NULL, now(),now()),
//( '765A3UJ7B11M', 3, 14, 0.00, NULL, 0.00, 1, 0.00, NULL, now(),now())
//;");

//        DB::Statement("INSERT INTO `billing_details` (`id`, `tracking_id`, `user_id`, `first_name`, `last_name`, `company_name`, `country`, `address1`, `address2`, `city`, `zip_code`, `phone`, `email`, `details`, `payment_method`, `created_at`, `updated_at`) VALUES
//(1, 'K3USKPJBC5U8', 3, 'Student', '', 'Spondon IT', '19', 'Dhaka', '', 'Dhaka', '1200', '01723442233', 'student@infixlms.com', 'add here additional info.', NULL,now(), now()),
//(2, '765A3UJ7B11M', 3, 'Student', '', 'Spondon IT', '19', 'Dhaka', '', 'Dhaka', '1200', '01723442233', 'student@infixlms.com', 'add here additional info.', NULL,now(), now())
//");
    }
}
