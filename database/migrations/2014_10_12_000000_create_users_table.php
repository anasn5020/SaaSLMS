<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::commit();
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->default(3);
            $table->string('name');
            $table->string('photo')->nullable();
            $table->string('image')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('notification_preference')->default('mail');
            $table->boolean('is_active')->default(TRUE);
            $table->string('username', 100)->nullable();
            $table->string('email', 100)->unique();
            $table->string('email_verify')->default(0);
            $table->string('password');
            $table->string('headline')->nullable();
            $table->string('phone', 100)->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('city')->nullable()->default(1374);
            $table->string('country')->nullable()->default(19);
            $table->string('zip')->nullable();
            $table->string('dob')->nullable();
            $table->longText('about')->nullable();
            $table->longText('short_details')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->integer('subscribe')->default(0);
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('language_id')->default(19);
            $table->string('language_code')->default('en');
            $table->string('language_name')->default('English');
            $table->boolean('status')->default(1);
            $table->float('balance')->default(0.00);
            $table->unsignedInteger('currency_id')->default(112);
            $table->integer('special_commission')->default(1);
            $table->string('payout')->default('PayPal');
            $table->string('payout_icon')->default('public/uploads/payout/pay_1.png');
            $table->string('payout_email')->default('demo@paypal.com');
            $table->string('referral', 10)->nullable()->unique();
            $table->boolean('added_by')->default(0);
            $table->string('zoom_api_key_of_user')->nullable();
            $table->string('zoom_api_serect_of_user')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::withoutEvents(function () {
            $data = User::find(1);

            if (empty($data)) {
                $user = new User();
                $user->role_id = 1;
                $user->name = 'Super Admin';
                $user->email = 'spn19@spondonit.com';
                $user->image = 'public/demo/user/admin.jpg';
                $user->username = null;
                $user->phone = '96897002784';
                $user->headline = 'Administrator';
                $user->about = "As the Super Admin of our platform, I bring over a decade of experience in managing and leading digital transformation initiatives. My journey began in the tech industry as a developer, and I have since evolved into a strategic leader with a focus on innovation and operational excellence. I am passionate about leveraging technology to solve complex problems and drive organizational growth. Outside of work, I enjoy mentoring aspiring tech professionals and staying updated with the latest industry trends.";
                $user->short_details = "Experienced tech leader with a decade in digital transformation. Passionate about innovation, problem-solving, and mentoring.";
                $user->email_verified_at = now();
                $user->password = Hash::make('12345678');
                $user->created_at = date('Y-m-d h:i:s');
                $user->referral = Str::random(10);
                $user->zoom_api_key_of_user = '';
                $user->zoom_api_serect_of_user = '';
                $user->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
