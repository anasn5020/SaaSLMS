<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

class UpdateEnvToSaasEnv extends Migration
{

    public function up()
    {
        $settings = [
            'APP_NAME' => env('APP_NAME'),
            'APP_URL' => env('APP_URL'),
            'APP_DEBUG' => env('APP_DEBUG') ? 'true' : 'false',
            'BROADCAST_DRIVER' => env('BROADCAST_DRIVER'),
            'CACHE_DRIVER' => env('CACHE_DRIVER'),
            'QUEUE_CONNECTION' => env('QUEUE_CONNECTION'),
            'SESSION_DRIVER' => env('SESSION_DRIVER'),
            'SESSION_LIFETIME' => env('SESSION_LIFETIME'),
            'REDIS_HOST' => env('REDIS_HOST'),
            'REDIS_PASSWORD' => env('REDIS_PASSWORD'),
            'REDIS_PORT' => env('REDIS_PORT'),
            'MAIL_DRIVER' => env('MAIL_DRIVER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
            'AWS_ACCESS_KEY_ID' => env('AWS_ACCESS_KEY_ID'),
            'AWS_SECRET_ACCESS_KEY' => env('AWS_SECRET_ACCESS_KEY'),
            'AWS_DEFAULT_REGION' => env('AWS_DEFAULT_REGION'),
            'AWS_BUCKET' => env('AWS_BUCKET'),
            'PUSHER_APP_ID' => env('PUSHER_APP_ID'),
            'PUSHER_APP_KEY' => env('PUSHER_APP_KEY'),
            'PUSHER_APP_SECRET' => env('PUSHER_APP_SECRET'),
            'PUSHER_APP_CLUSTER' => env('PUSHER_APP_CLUSTER'),
            'TIME_ZONE' => env('TIME_ZONE'),
            'MIX_PUSHER_APP_KEY' => env('MIX_PUSHER_APP_KEY'),
            'MIX_PUSHER_APP_CLUSTER' => env('MIX_PUSHER_APP_CLUSTER'),
            'VIMEO_CLIENT' => env('VIMEO_CLIENT'),
            'VIMEO_SECRET' => env('VIMEO_SECRET'),
            'VIMEO_ACCESS' => env('VIMEO_ACCESS'),
            'VIMEO_COMMON_USE' => env('VIMEO_COMMON_USE') ? 'true' : 'false',
            'VIMEO_UPLOAD_TYPE' => env('VIMEO_UPLOAD_TYPE'),
            'ZOOM_CLIENT_KEY' => env('ZOOM_CLIENT_KEY'),
            'ZOOM_CLIENT_SECRET' => env('ZOOM_CLIENT_SECRET'),
            'BBB_SECURITY_SALT' => env('BBB_SECURITY_SALT'),
            'BBB_SERVER_BASE_URL' => env('BBB_SERVER_BASE_URL'),
            'FIXER_ACCESS_KEY' => env('FIXER_ACCESS_KEY'),
            'FORCE_HTTPS' => env('FORCE_HTTPS') ? 'true' : 'false',
            'NOCAPTCHA_SITEKEY' => env('NOCAPTCHA_SITEKEY'),
            'NOCAPTCHA_SECRET' => env('NOCAPTCHA_SECRET'),
            'NOCAPTCHA_IS_INVISIBLE' => env('NOCAPTCHA_IS_INVISIBLE') ? 'true' : 'false',
            'NOCAPTCHA_FOR_LOGIN' => env('NOCAPTCHA_FOR_LOGIN') ? 'true' : 'false',
            'NOCAPTCHA_FOR_REG' => env('NOCAPTCHA_FOR_REG') ? 'true' : 'false',
            'NOCAPTCHA_FOR_CONTACT' => env('NOCAPTCHA_FOR_CONTACT') ? 'true' : 'false',
            'VDOCIPHER_API_SECRET' => env('VDOCIPHER_API_SECRET'),
            'ALLOW_GOOGLE_LOGIN' => env('ALLOW_GOOGLE_LOGIN') ? 'true' : 'false',
            'GOOGLE_CLIENT_ID' => env('GOOGLE_CLIENT_ID'),
            'GOOGLE_CLIENT_SECRET' => env('GOOGLE_CLIENT_SECRET'),
            'FACEBOOK_CLIENT_ID' => env('FACEBOOK_CLIENT_ID'),
            'FACEBOOK_CLIENT_SECRET' => env('FACEBOOK_CLIENT_SECRET'),
            'ALLOW_FACEBOOK_LOGIN' => env('ALLOW_FACEBOOK_LOGIN') ? 'true' : 'false',
            'ACELLE_STATUS' => env('ACELLE_STATUS') ? 'true' : 'false',
            'ACELLE_API_URL' => env('ACELLE_API_URL'),
            'ACELLE_API_TOKEN' => env('ACELLE_API_TOKEN'),
            'FCM_SECRET_KEY' => env('FCM_SECRET_KEY'),
        ];


        $domain = 'main';
        $path = Storage::path('saas_env.json');
        if (!Storage::has('saas_env.json')) {
            $strJsonFileContents = null;
        } else {
            $strJsonFileContents = file_get_contents($path);
        }

        $file_data = json_decode($strJsonFileContents, true);

        $new_setting = new \stdClass;
        foreach ($settings as $key => $value) {
            $new_setting->{$key} = $value;
        }
        $setting_array[$domain] = $new_setting;
        if (!empty($file_data)) {
            $merged_array = array_merge($file_data, $setting_array);
            $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
        } else {
            $merged_array = json_encode($setting_array, JSON_PRETTY_PRINT);
        }
        file_put_contents($path, $merged_array);


    }


    public function down()
    {

    }


}
