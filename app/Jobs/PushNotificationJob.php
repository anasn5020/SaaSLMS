<?php

namespace App\Jobs;

use App\Services\GoogleFCMTokenService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title, $details, $device_token, $type, $id;

    public function __construct($title, $details, $device_token, $id = null, $type = null)
    {
        $this->title = $title;
        $this->details = $details;
        $this->device_token = $device_token;
        $this->id = $id;
        $this->type = $type;
    }


    public function handle()
    {
        $googleTokenService = new GoogleFCMTokenService();
        try {
            $json = Storage::get(SaasDomain() . '-firebase-service-account.json');
            $data = json_decode($json, true);
            $accessToken = $googleTokenService->getCachedAccessToken();
        } catch (Exception $e) {
            Cache::forget('google_access_token_'.SaasDomain());
            Log::error($e->getMessage());
            return false;
        }


        $projectId = $data['project_id']??'';
     $response =   Http::withToken($accessToken)->post('https://fcm.googleapis.com/v1/projects/'.$projectId.'/messages:send', [
            'message' => [
                'token' => $this->device_token,
                'notification' => [
                    'title' => $this->title,
                    'body' => $this->details,
                ],
                'data' => [
                    "priority" => "high",
                    "title" => $this->title,
                    "body" => $this->details,
                    "type" => $this->type,
                    "id" => $this->id,
                    "image" => getCourseImage(Settings('logo'))
                ],
            ],
        ]);

        if ($response->successful()) {
            Log::info('Push notification send successfully');
        }else{
            Cache::forget('google_access_token_'.SaasDomain());
            $responseResult  = $response->json();
            Log::info($responseResult);
        }
    }

}
