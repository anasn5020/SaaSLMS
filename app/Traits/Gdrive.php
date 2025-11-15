<?php

namespace App\Traits;

use App\GoogleToken;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait Gdrive
{
    private $drive, $client, $folder_id;

    public function __construct(Google_Client $client)
    {
        $this->client = $client;
        $client->setClientId(saasEnv('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(saasEnv('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->setRedirectUri(saasEnv('GOOGLE_DRIVE_REDIRECT'));
     }

    public function getDrive()
    {
        $query = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
        $optParams = [
            'fields' => 'files(id,name)',
            'q' => $query,
            'supportsAllDrives' => true,
            'includeItemsFromAllDrives' => true,
        ];
        return $this->drive->files->listFiles($optParams);
    }

    function createFile($file, $parent_id = null)
    {
        $name = gettype($file) === 'object' ? $file->getClientOriginalName() : $file;
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $name,
            'parents' => !empty($parent_id) ? array($parent_id) : 'root'
        ]);
        $content = gettype($file) === 'object' ? File::get($file) : Storage::get($file);
        $mimeType = gettype($file) === 'object' ? File::mimeType($file) : Storage::mimeType($file);
        return $this->drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
    }

    function storeFileInGDrive($file, $parent_id = null)
    {
        $this->configureSetting($this->client); // config

        $name = explode('/', $file);
        $file_name = end($name);
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $file_name,
            'type' => ['anyone'],
            'parents' => !empty($parent_id) ? array($parent_id) : [$this->folder_id]
        ]);

        return $this->drive->files->create($fileMetadata, [
            'data' => file_get_contents($file),
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media',
            'fields' => 'id',
        ]);
    }

    public function configureSetting($client)
    {
        $user = auth()->user();
        $token = $user->googleToken ?? '';
        if ($token && $token->token) {
            $accessToken = [
                'access_token' => $token->token,
                'created' => $user->created_at->timestamp,
                'expires_in' => $token->expires_in,
                'refresh_token' => $token->refresh_token
            ];
            $this->serviceInitiator($client, $user, $accessToken);
            $this->createDriveFolder(env('APP_NAME'), $token, 'backup');
        }
    }

    private function serviceInitiator($client, $user, $accessToken)
    {
        if (empty($client)) {
            $client = new Google_Client();
            $client->setClientId(saasEnv('GOOGLE_DRIVE_CLIENT_ID'));
            $client->setClientSecret(saasEnv('GOOGLE_DRIVE_CLIENT_SECRET'));
            $client->setRedirectUri(saasEnv('GOOGLE_DRIVE_REDIRECT'));
        }
        $client->setAccessToken($accessToken);

        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            }

            $user->googleToken()->update([
                'token' => $client->getAccessToken()['access_token'],
                'expires_in' => $client->getAccessToken()['expires_in'],
                'created_at' => $client->getAccessToken()['created'],
            ]);
        }

        $client->refreshToken(@$user->googleToken->refresh_token);
        $this->drive = new Google_Service_Drive($client);
    }

    private function createDriveFolder($folder_name, $token, $type)
    {
        if ($folder_name) {
            $folder_id = '';
            $arr = [];
            $query = "mimeType='application/vnd.google-apps.folder' and name='" . $folder_name . "' and 'root' in parents and trashed=false";
            $optParams = [
                'fields' => 'files(id,name)',
                'q' => $query,
                'supportsAllDrives' => true,
                'includeItemsFromAllDrives' => true,
            ];
            $files = $this->drive->files->listFiles($optParams);
            foreach ($files as $file) {
                $arr[] = $file->getID();
            }
            if (count($arr) == 0) {
                $folder_id = $this->createGDriveFolder($folder_name);
            }
            $this->folder_id = count($arr) > 0 ? $arr[0] : $folder_id;
            if ($type == 'backup') {
                $token->update([
                    'backup_folder_id' => $this->folder_id,
                    'backup_folder_name' => env('APP_NAME'),
                ]);

            }
        }
    }

    function createGDriveFolder($folder_name, $parent_id = null)
    {
        $role = 'writer';
        $userPermission = new Google_Service_Drive_Permission(array(
            'type' => 'anyone',
            'role' => $role,
        ));
        $folder_meta = new Google_Service_Drive_DriveFile(array(
            'name' => $folder_name,
            'parents' => [$parent_id],
            'mimeType' => 'application/vnd.google-apps.folder'
        ));
        $folder = $this->drive->files->create($folder_meta, array('fields' => 'id'));
        $this->drive->permissions->create(
            $folder->id,
            $userPermission,
            array('fields' => 'id')
        );
        return $folder->id;
    }

    function storeContentInGDrive($content, $file_name)
    {
        $this->configureSetting($this->client);

        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $file_name,
            'type' => ['anyone'],
            'parents' => !empty($parent_id) ? array($parent_id) : [$this->folder_id]
        ]);

        $file = $this->drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'application/octet-stream',
            'uploadType' => 'media',
            'fields' => 'id',
        ]);

        $fileId = $file->id;
        return "https://drive.google.com/uc?id=$fileId";
    }

    function deleteFileByUrl($url)
    {
        $this->configureSetting($this->client);

        $fileId = $this->getFileIdFromUrl($url);

        if ($fileId) {
            $driveService = new Google_Service_Drive($this->client);

            try {
                $driveService->files->delete($fileId);
                return true;
            } catch (\Exception $e) {
                dd($e);
                return false;
            }
        }
    }

    private function getFileIdFromUrl($fileUrl)
    {
        // Extract the file ID from the Google Drive URL
        // You might need to customize this based on the format of your URLs
        $matches = [];
        if (preg_match('/[a-zA-Z0-9_-]{28,}/', $fileUrl, $matches)) {
            return $matches[0];
        }

        return null;
    }

    public function searchByName($folder_name)
    {
        $query = "mimeType='application/vnd.google-apps.folder' and name='" . $folder_name . "' and 'root' in parents and trashed=false";
        $optParams = [
            'fields' => 'files(id,name)',
            'q' => $query,
            'supportsAllDrives' => true,
            'includeItemsFromAllDrives' => true,
        ];

        $results = $this->drive->files->listFiles($optParams);
        return $results->getFiles();
    }

    public function storageDetails()
    {
        $headers = array(
            "Authorization: Bearer " . @superAdmin()->user->googleToken->token,
            'Accept: application/json'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.googleapis.com/drive/v3/about?fields=storageQuota&key=" . env('GOOGLE_CLIENT_SECRET'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $decode_response = json_decode($response);
        if ($err) {
            $data = [];
        } else {

            Log::info($decode_response);
            $disk_info = $decode_response->storageQuota;
            Log::info($disk_info);
            $left = $disk_info->limit - $disk_info->usage;
            $data = [
                'usage' => number_format($disk_info->limit / 1073700000, 2),
                'maximum' => number_format($disk_info->usage / 1073700000, 2),
                'left' => number_format($left / 1073700000, 2),
            ];
        }
        return $data;
    }

    public function googleDrive($attendance, $user)
    {
        /*GoogleToken::where('user_id', auth()->id())->where(function ($query) use($attendance){
            $query->where('attendance_id','!=',$attendance->id)->orWhere('attendance_id',null);
        })->delete();*/
        $user_email = $attendance->user->email;
        $folder_id = generalSetting('attendance_folder_id');
        if (!$folder_id) {
            $folder_id = superAdmin()->user->googleToken->attendance_folder_id;
        }
        $year_id = $this->specificFolderSearch($folder_id, date('Y'));

        if ($year_id) {
            $month_id = $this->specificFolderSearch($year_id, date('F'));
            if ($month_id) {
                $date_id = $this->specificFolderSearch($month_id, date('d M'));
                if ($date_id) {
                    $email_id = $this->specificFolderSearch($date_id, $user_email);
                    if (!$email_id) {
                        $email_id = $this->createGDriveFolder($user_email, $date_id);
                        GoogleToken::create([
                            'user_id' => \auth()->id(),
                            'attendance_folder_id' => $email_id,
                            'attendance_id' => $attendance->id
                        ]);
                    }
                } else {
                    $date_id = $this->createGDriveFolder(date('d M'), $month_id);
                    $email_id = $this->createGDriveFolder($user_email, $date_id);
                    GoogleToken::create([
                        'user_id' => \auth()->id(),
                        'attendance_folder_id' => $email_id,
                        'attendance_id' => $attendance->id
                    ]);
                }
            } else {
                $month_id = $this->createGDriveFolder(date('F'), $year_id);
                $date_id = $this->createGDriveFolder(date('d M'), $month_id);
                $email_id = $this->createGDriveFolder($user_email, $date_id);
                GoogleToken::create([
                    'user_id' => \auth()->id(),
                    'attendance_folder_id' => $email_id,
                    'attendance_id' => $attendance->id
                ]);
            }
        } else {
            $attendance_folder_id = generalSetting('attendance_folder_id');
            if (!$attendance_folder_id) {
                $attendance_folder_id = @$user->googleToken->attendance_folder_id;
            }
            $year_id = $this->createGDriveFolder(date('Y'), $attendance_folder_id);
            $month_id = $this->createGDriveFolder(date('F'), $year_id);
            $date_id = $this->createGDriveFolder(date('d M'), $month_id);
            $email_id = $this->createGDriveFolder($user_email, $date_id);
            GoogleToken::create([
                'user_id' => \auth()->id(),
                'attendance_folder_id' => $email_id,
                'attendance_id' => $attendance->id
            ]);
        }
    }

    public function specificFolderSearch($folder_id, $match): string
    {
        $id = '';
        $folders = $this->listOfFiles($folder_id);
        if (count($folders) > 0) {
            foreach ($folders as $folder) {
                if ($folder->getName() == $match) {
                    $id = $folder->getID();
                    break;
                }
            }
        }
        return $id;
    }

    public function listOfFiles($id)
    {
        $folder_id = $id;

        if ($folder_id) {
            $query = "'$folder_id' in parents and trashed=false";
            $optParams = [
                'fields' => 'files(id,name)',
                'q' => $query,
                'supportsAllDrives' => true,
                'includeItemsFromAllDrives' => true,
            ];
            $results = $this->drive->files->listFiles($optParams);
            $files = $results->getFiles();
        } else {
            $files = [];
        }
        return $files;
    }
}
