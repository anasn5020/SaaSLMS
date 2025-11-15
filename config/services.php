<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => saasEnv('AWS_ACCESS_KEY_ID'),
        'secret' => saasEnv('AWS_SECRET_ACCESS_KEY'),
        'region' => saasEnv('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'facebook' => [
        'client_id' => saasEnv('FACEBOOK_CLIENT_ID'),
        'client_secret' => saasEnv('FACEBOOK_CLIENT_SECRET'),
        'redirect' => saasEnv('APP_URL') . '/oauth/facebook/callback',
    ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),  // Your Twitter Client ID
        'client_secret' => env('TWITTER_CLIENT_SECRET'), // Your Twitter Client Secret
        'redirect' => env('TWITTER_CALLBACK_URL'),
    ],
    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env('LINKEDIN_CALLBACK_URL'),
    ],

    'google' => [
        'client_id' => saasEnv('GOOGLE_CLIENT_ID'),
        'client_secret' => saasEnv('GOOGLE_CLIENT_SECRET'),
        'redirect' => saasEnv('APP_URL') . '/oauth/google/callback',
    ],

    'google-drive' => [
        'client_id' => saasEnv('GOOGLE_DRIVE_CLIENT_ID'),
        'auth_uri' => 'https://accounts.google.com/o/oauth2/auth',
        'token_uri' => 'https://accounts.google.com/o/oauth2/token',
        'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
        'client_secret' => saasEnv('GOOGLE_DRIVE_CLIENT_SECRET'),
        'redirect' => saasEnv('GOOGLE_DRIVE_REDIRECT'),
        'redirect_uris' => [[saasEnv('GOOGLE_DRIVE_REDIRECT')]],
    ],
    'paytm' => [
        'env' => getPaymentEnv('PAYTM_ENVIRONMENT'), // values : (local | production)
        'merchant_id' => getPaymentEnv('PAYTM_MERCHANT_ID'),
        'merchant_key' => getPaymentEnv('PAYTM_MERCHANT_KEY'),
        'merchant_website' => getPaymentEnv('PAYTM_MERCHANT_WEBSITE'),
        'channel' => getPaymentEnv('PAYTM_CHANNEL'),
        'industry_type' => getPaymentEnv('PAYTM_INDUSTRY_TYPE'),
    ],
    'fcm' => [
        'key' => saasEnv('FCM_SECRET_KEY')
    ],
    'google_calendar' => [
        'client_id' => saasEnv('GOOGLE_CALENDAR_CLIENT_ID'),
        'client_secret' => saasEnv('GOOGLE_CALENDAR_CLIENT_SECRET'),
        'redirect_uri' => saasEnv('GOOGLE_CALENDAR_REDIRECT_URI'),
        'scopes' => [
            \Google_Service_Oauth2::USERINFO_EMAIL,
            \Google_Service_Calendar::CALENDAR,
        ],
        'approval_prompt' => 'force',
        'access_type' => 'offline',
        'include_granted_scopes' => true,
    ],
    'google_meet' => [
        'client_id' => saasEnv('GOOGLE_MEET_CLIENT_ID'),
        'client_secret' => saasEnv('GOOGLE_MEET_CLIENT_SECRET'),
        'redirect_uri' => saasEnv('GOOGLE_MEET_REDIRECT_URI'),
        'scopes' => [
            \Google_Service_Oauth2::USERINFO_EMAIL,
            \Google_Service_Calendar::CALENDAR,
        ],
        'approval_prompt' => 'force',
        'access_type' => 'offline',
        'include_granted_scopes' => true,
    ],


];
