<?php

namespace Modules\CourseSetting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\VimeoSetting\Entities\Vimeo;

class VimeoController extends Controller
{
    /**
     * Fetch all Vimeo data
     */
    public function getAllVimeoData(Request $request)
    {
        try {
            $video_list = [];
            $access_token = $this->configVimeo();

            if (empty($access_token)) {
                return $video_list;
            }

            $page = $request->get('page', 1);
            $search = $request->get('search', '');

            $vimeo_video_list = $this->getVideoFromVimeoApi($page, $search);

            if (isset($vimeo_video_list['data'])) {
                foreach ($vimeo_video_list['data'] as $data) {
                    $video_list[] = $data;
                }
            }

        } catch (Exception $e) {
            Log::error("Error fetching Vimeo data: " . $e->getMessage());
        }

        $response = [];
        foreach ($video_list as $item) {
            $response[] = [
                'id' => $item['uri'],
                'text' => $item['name'],
            ];
        }

        $output['results'] = $response;
        $output['pagination'] = ["more" => count($response) != 0];

        return response()->json($output);
    }

    /**
     * Configure Vimeo access token
     */
    public function configVimeo()
    {
        try {
            if (config('vimeo.connections.main.common_use')) {
                $vimeo_access = saasEnv('VIMEO_ACCESS');
            } else {
                $vimeos = Cache::rememberForever('vimeoSetting_' . SaasDomain(), function () {
                    return Vimeo::all();
                });
                $vimeo = $vimeos->where('created_by', Auth::user()->id)->first();
                $vimeo_access = $vimeo?->vimeo_access;
            }

            return $vimeo_access ?: null;
        } catch (Exception $e) {
            Log::error("Error configuring Vimeo: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch videos from Vimeo API
     */
    public function getVideoFromVimeoApi($page = 1, $search = null)
    {
        try {
            if (config('vimeo.connections.main.upload_type') == "Direct") {
                return [];
            }

            $access_token = $this->configVimeo();

            if (!$access_token) {
                return [];
            }

            $response = Http::withToken($access_token)
                ->withHeaders([
                    'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
                ])
                ->get('https://api.vimeo.com/me/videos', [
                    'per_page' => 10,
                    'page' => $page,
                    'query' => $search,
                ]);
            return $response->successful() ? $response->json() : [];
        } catch (Exception $e) {
            Log::error("Error fetching Vimeo videos: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetch single Vimeo data
     */
    public function getSingleVimeoData(Request $request)
    {
        try {
            $access_token = $this->configVimeo();

            if (!$access_token) {
                return null;
            }
            $uri = $request->get('uri', '');
            $response = Http::withToken($access_token)
                ->withHeaders([
                    'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
                ])
                ->get('https://api.vimeo.com/' . $uri);

            return $response->successful() ? response()->json($response->json()) : null;
        } catch (Exception $e) {
            Log::error("Error fetching single Vimeo video: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Upload a file to Vimeo
     */
    public function uploadFileIntoVimeo($course_title, $file)
    {
        try {
            $access_token = $this->configVimeo();

            if (!$access_token) {
                return null;
            }

            // Step 1: Start the upload
            $response = Http::withToken($access_token)
                ->withHeaders([
                    'Accept' => 'application/vnd.vimeo.*+json;version=3.4',
                ])
                ->post('https://api.vimeo.com/me/videos', [
                    'upload' => [
                        'approach' => 'tus',
                        'size' => filesize($file),
                    ],
                    'name' => $course_title,
                    'privacy' => [
                        'view' => 'disable',
                        'embed' => 'whitelist',
                    ],
                    'embed' => [
                        'title' => [
                            'name' => 'hide',
                            'owner' => 'hide',
                        ],
                    ],
                ]);

            if (!$response->successful()) {
                throw new Exception('Failed to start Vimeo upload: ' . $response->body());
            }

            $upload_link = $response->json()['upload']['upload_link'];

            // Step 2: Upload the file
            $file_upload_response = Http::attach('file', file_get_contents($file), basename($file))
                ->put($upload_link);

            if (!$file_upload_response->successful()) {
                throw new Exception('Failed to upload file to Vimeo: ' . $file_upload_response->body());
            }

            // Step 3: Set domain privacy
            $video_uri = $response->json()['uri'];
            Http::withToken($access_token)
                ->put("https://api.vimeo.com{$video_uri}/privacy/domains/" . request()->getHttpHost());

            return $video_uri;
        } catch (Exception $e) {
            Toastr::error($e->getMessage(), trans('common.Failed'));
            Log::error("Error uploading file to Vimeo: " . $e->getMessage());
            return null;
        }
    }
}
