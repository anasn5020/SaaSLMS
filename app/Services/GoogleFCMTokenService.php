<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GoogleFCMTokenService
{
    protected $credentials;

    public function __construct()
    {
        $this->loadCredentials();

     }
    protected function loadCredentials()
    {
        $filePath = storage_path('app/' . SaasDomain() . '-firebase-service-account.json');
        if (!file_exists($filePath)) {
            $this->createCredentialsFile();
        }

        $this->credentials = json_decode(file_get_contents($filePath), true);
    }
    protected function createCredentialsFile()
    {
        $defaultContent = [
            "type" => "service_account",
            "project_id" => "your-project-id",
            "private_key_id" => "your-private-key-id",
            "private_key" => "-----BEGIN PRIVATE KEY-----\nYOUR_PRIVATE_KEY_CONTENT\n-----END PRIVATE KEY-----\n",
            "client_email" => "your-client-email",
            "client_id" => "your-client-id",
            "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
            "token_uri" => "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/your-client-email"
        ];

        Storage::put( SaasDomain() . '-firebase-service-account.json', json_encode($defaultContent, JSON_PRETTY_PRINT));
    }

    public function getCachedAccessToken()
    {
        $cacheKey = 'google_access_token_'.SaasDomain();
        if (Cache::has($cacheKey) && !empty(Cache::get($cacheKey))) {
            return Cache::get($cacheKey);
        } else {
            $accessToken = $this->getAccessToken();
            Cache::put($cacheKey, $accessToken, 3600); // Cache for 1 hour
            return $accessToken;
        }

    }
    public function getAccessToken()
    {
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $jwt = $this->createJwt();
        $response = Http::asForm()->post($tokenUrl, [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if ($response->successful()) {
            return $response->json()['access_token']??"";
        } else{
            Log::error(json_encode( $response->body()));
        }
    }

    private function createJwt()
    {
        $now = time();
        $expiration = $now + 3600; // Token valid for 1 hour

        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $payload = [
            'iss' =>$this->credentials['client_email']??'',
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $expiration,
        ];

        $privateKey = $this->credentials['private_key']??'';
         return JWT::encode($payload, $privateKey, 'RS256', null, $header);
    }
}
