<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;
use Modules\PaymentMethodSetting\Entities\PaymentMethodCredential;

class CreatePaymentMethodCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_method_credentials', function (Blueprint $table) {
            $table->id();
            //Instamojo
            $table->string('Instamojo_API_AUTH')->nullable();
            $table->string('Instamojo_API_AUTH_TOKEN')->nullable();
            $table->string('Instamojo_URL')->nullable();
            //MIDTRANS
            $table->string('MIDTRANS_SERVER_KEY')->nullable();
            $table->string('MIDTRANS_ENV')->nullable();
            $table->string('MIDTRANS_SANITIZE')->nullable();
            $table->string('MIDTRANS_3DS')->nullable();
            //PAYEER
            $table->string('PAYEER_MERCHANT')->nullable();
            $table->string('PAYEER_KEY')->nullable();
            //SSLCommerz
            $table->string('STORE_ID')->nullable();
            $table->string('STORE_PASSWORD')->nullable();
            $table->string('IS_LOCALHOST')->nullable();
            //PESAPAL
            $table->string('PESAPAL_KEY')->nullable();
            $table->string('PESAPAL_SECRET')->nullable();
            $table->string('PESAPAL_IS_LIVE')->nullable();
            $table->string('PESAPAL_CALLBACK')->nullable();
            //MOBILPAY
            $table->string('MOBILPAY_MERCHANT_ID')->nullable();
            $table->string('MOBILPAY_TEST_MODE')->nullable();
            $table->string('MOBILPAY_PUBLIC_KEY_PATH')->nullable();
            $table->string('MOBILPAY_PRIVATE_KEY_PATH')->nullable();
            //PAYPAL
            $table->string('PAYPAL_CLIENT_ID')->nullable();
            $table->string('PAYPAL_CLIENT_SECRET')->nullable();
            $table->string('IS_PAYPAL_LOCALHOST')->nullable();
            //STRIPE
            $table->string('STRIPE_SECRET')->nullable();
            $table->string('STRIPE_KEY')->nullable();
            //PAYSTACK
            $table->string('PAYSTACK_PUBLIC_KEY')->nullable();
            $table->string('PAYSTACK_SECRET_KEY')->nullable();
            $table->string('MERCHANT_EMAIL')->nullable();
            $table->string('PAYSTACK_PAYMENT_URL')->nullable();
            //RAZOR
            $table->string('RAZOR_KEY')->nullable();
            $table->string('RAZOR_SECRET')->nullable();
            //PAYTM
            $table->string('PAYTM_MERCHANT_ID')->nullable();
            $table->string('PAYTM_ENVIRONMENT')->nullable();
            $table->string('PAYTM_MERCHANT_KEY')->nullable();
            $table->string('PAYTM_MERCHANT_WEBSITE')->nullable();
            $table->string('PAYTM_CHANNEL')->nullable();
            $table->string('PAYTM_INDUSTRY_TYPE')->nullable();
            //BKASH
            $table->string('BKASH_APP_KEY')->nullable();
            $table->string('BKASH_APP_SECRET')->nullable();
            $table->string('BKASH_USERNAME')->nullable();
            $table->string('BKASH_PASSWORD')->nullable();
            $table->string('IS_BKASH_LOCALHOST')->nullable();
            //BANK
            $table->string('BANK_NAME')->nullable();
            $table->string('BRANCH_NAME')->nullable();
            $table->string('ACCOUNT_TYPE')->nullable();
            $table->string('ACCOUNT_NUMBER')->nullable();
            $table->string('ACCOUNT_HOLDER')->nullable();


            $table->tinyInteger('lms_id')->default(1);

            $table->timestamps();
        });

        $settings = [
            'PAYPAL_CLIENT_ID' => env('PAYPAL_CLIENT_ID'),
            'PAYPAL_CLIENT_SECRET' => env('PAYPAL_CLIENT_SECRET'),
            'IS_PAYPAL_LOCALHOST' => env('IS_PAYPAL_LOCALHOST'),
            'STRIPE_KEY' => env('STRIPE_KEY'),
            'STRIPE_SECRET' => env('STRIPE_SECRET'),
            'RAZOR_KEY' => env('RAZOR_KEY'),
            'RAZOR_SECRET' => env('RAZOR_SECRET'),
            'PAYTM_ENVIRONMENT' => env('PAYTM_ENVIRONMENT'),
            'PAYTM_MERCHANT_ID' => env('PAYTM_MERCHANT_ID'),
            'PAYTM_MERCHANT_KEY' => env('PAYTM_MERCHANT_KEY'),
            'PAYTM_MERCHANT_WEBSITE' => env('PAYTM_MERCHANT_WEBSITE'),
            'PAYTM_CHANNEL' => env('PAYTM_CHANNEL'),
            'PAYTM_INDUSTRY_TYPE' => env('PAYTM_INDUSTRY_TYPE'),
            'PAYSTACK_PUBLIC_KEY' => env('PAYSTACK_PUBLIC_KEY'),
            'PAYSTACK_SECRET_KEY' => env('PAYSTACK_SECRET_KEY'),
            'PAYSTACK_PAYMENT_URL' => env('PAYSTACK_PAYMENT_URL'),
            'MERCHANT_EMAIL' => env('MERCHANT_EMAIL'),
            'BANK_NAME' => env('BANK_NAME'),
            'BRANCH_NAME' => env('BRANCH_NAME'),
            'ACCOUNT_NUMBER' => env('ACCOUNT_NUMBER'),
            'ACCOUNT_HOLDER' => env('ACCOUNT_HOLDER'),
            'ACCOUNT_TYPE' => env('ACCOUNT_TYPE'),
            'Instamojo_API_AUTH' => env('Instamojo_API_AUTH'),
            'Instamojo_API_AUTH_TOKEN' => env('Instamojo_API_AUTH_TOKEN'),
            'Instamojo_URL' => env('Instamojo_URL'),
            'MIDTRANS_SERVER_KEY' => env('MIDTRANS_SERVER_KEY'),
            'MIDTRANS_ENV' => env('MIDTRANS_ENV'),
            'MIDTRANS_SANITIZE' => env('MIDTRANS_SANITIZE'),
            'MIDTRANS_3DS' => env('MIDTRANS_3DS'),
            'PAYEER_MERCHANT' => env('PAYEER_MERCHANT'),
            'PAYEER_KEY' => env('PAYEER_KEY'),
            'PESAPAL_KEY' => env('PESAPAL_KEY'),
            'PESAPAL_SECRET' => env('PESAPAL_SECRET'),
            'PESAPAL_IS_LIVE' => env('PESAPAL_IS_LIVE'),
            'PESAPAL_CALLBACK' => env('PESAPAL_CALLBACK'),
            'BKASH_APP_KEY' => env('BKASH_APP_KEY'),
            'BKASH_APP_SECRET' => env('BKASH_APP_SECRET'),
            'BKASH_USERNAME' => env('BKASH_USERNAME'),
            'BKASH_PASSWORD' => env('BKASH_PASSWORD'),
            'IS_BKASH_LOCALHOST' => env('IS_BKASH_LOCALHOST'),
        ];

        try {
            \Illuminate\Support\Facades\DB::table('payment_method_credentials')->insert($settings);

            $path = Storage::path('payment.json');
            $new_setting = new \stdClass;
            if ($settings) {
                foreach ($settings as $key => $value) {
                    $new_setting->{$key} = $value;
                }
            }

            $setting_array['main'] = $new_setting;

            $merged_array = json_encode($setting_array, JSON_PRETTY_PRINT);
            file_put_contents($path, $merged_array);
        } catch (\Exception $exception) {
            \Illuminate\Support\Facades\Log::error($exception);
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_method_credentials');
    }
}
