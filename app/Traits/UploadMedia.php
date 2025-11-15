<?php

namespace App\Traits;

use Carbon\Carbon;
use Google_Client;
use Illuminate\Support\Facades\File;
use Modules\AmazonS3\Http\Controllers\AmazonS3Controller;
use Modules\BunnyStorage\Service\BunnyVideoStream;
use Modules\Setting\Entities\MediaManager;
use Modules\Setting\Entities\UsedMedia;
use Modules\Setting\Http\Controllers\GoogleDriveController;
use Modules\Storage\Services\StorageUpload;

trait UploadMedia
{

    public static function deleteFile($url)
    {
        if (strpos($url, 'amazonaws.com') != false) {

            return (new AmazonS3Controller())->deleteFile($url);

        } elseif (strpos($url, 'digitaloceanspaces.com') != false && isModuleActive('Storage')) {

            return StorageUpload::deleteFromStorage('do', $url);

        } elseif (strpos($url, 'drive.google.com') != false) {

            return (new GoogleDriveController(new Google_Client()))->deleteFile($url);

        } elseif (strpos($url, 'wasabisys.com') != false && isModuleActive('Storage')) {

            return StorageUpload::deleteFromStorage('Wasabi', $url);

        } elseif (strpos($url, 'backblazeb2.com') != false && isModuleActive('Storage')) {

            return StorageUpload::deleteFromStorage('b2', $url);

        } elseif (strpos($url, 'dropboxusercontent.com') != false && isModuleActive('Storage')) {

            return StorageUpload::deleteFromStorage('dropbox', $url);

        } elseif (strpos($url, 'b-cdn.net') != false && isModuleActive('Storage')) {

            return (new BunnyVideoStream())->deleteFile($url);

        } elseif (strpos($url, 'contabostorage.com') != false && isModuleActive('Storage')) {

            return StorageUpload::deleteFromStorage('contabo', $url);

        } else {
            if (File::exists($url)) {
                File::delete($url);
                return true;
            } else {
                return false;
            }
        }
    }

    public static function mediaUpload($file = null)
    {
        if (!isset($file)) {
            abort('404');
        }

        $originalName = $file->getClientOriginalName();
        $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
        $ignoreType = [
            'php',
            'js',
            'css',
            'md',
            'sh',
            'exe',
            'bin',
            'bat'
        ];

        if (in_array(strtolower($fileExtension), $ignoreType)) {
            abort('403');

        }
        $fileSizeInKB = round(filesize($file) / 1024);
        $host = Settings('active_storage') ?: 'LocalStorage';

        $domain = SaasDomain();
        $current_date = Carbon::now()->format('d-m-Y');
        $dir = 'public/uploads/' . $domain . '/files/' . $current_date;
        $data = [
            'original_name' => $originalName,
            'extension' => $fileExtension,
            'type' => self::extToType($fileExtension),
            'size' => $fileSizeInKB,
        ];

        if (in_array($host, ['AmazonS3', 'GoogleDrive', 'BunnyCDN', 'DigitalOcean', 'Wasabi', 'Backblaze', 'Dropbox', 'Contabo'])) {
            $fileContents = file_get_contents($file);
            $fileContentsBase64 = base64_encode($fileContents);


            switch ($host) {
                case 'GoogleDrive':
                    $drive = new GoogleDriveController(new Google_Client());
                    $fileUrl = $drive->storeContentInGDrive(base64_decode($fileContentsBase64), $originalName);
                    break;

                case 'AmazonS3':
                    $fileUrl = AmazonS3Controller::s3Upload('s3', $fileContentsBase64, $fileExtension);
                    break;

                case 'BunnyCDN':
                    $fileUrl = self::uploadToStorage('google', $fileContentsBase64, $fileExtension);
                    break;

                default:
                    break;
            }
            $data['file_name'] = $fileUrl;
            $data['storage'] = $host;
        } else {

            if (!File::isDirectory($dir)) {
                File::makeDirectory($dir, 0777, true, true);
            }

            $file->move($dir, $originalName);
            $data['file_name'] = $dir . '/' . $originalName;
            $data['storage'] = 'local';
        }

        return $data;
    }

    private static function extToType($ext)
    {
        if (in_array($ext,  ['png', 'jpeg', 'jpg', 'svg', 'gif', 'bmp', 'tiff', 'webp'])) {
            $type = 'image';
        } elseif (in_array($ext,['mp4', 'avi', 'mkv', 'mov', 'wmv', 'flv'])) {
            $type = 'video';
        } elseif (in_array($ext, ['pdf'])) {
            $type = 'pdf';
        }elseif (in_array($ext, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'])) {
            $type = 'doc';
        } elseif (in_array($ext, ['ttf', 'otf', 'woff', 'woff2', 'eot'])) {
            $type = 'font';
        }  elseif (in_array($ext, ['zip', 'rar', '7z', 'tar', 'gz'])) {
            $type = 'zip';
        } else {
            $type = 'invalid';
        }
        return $type;
    }

    public function generateLink($media_id, $usable_id, $class, $used_for)
    {
        $link = null;
        $media = MediaManager::find($media_id);
        if ($media) {
            UsedMedia::create([
                'media_id' => $media_id,
                'usable_id' => $usable_id,
                'usable_type' => $class,
                'used_for' => $used_for
            ]);
            $link = $media->file_name;
        }
        return $link;
    }

    public function removeLink($usable_id, $usable_type)
    {
        UsedMedia::where([
            'usable_id' => $usable_id,
            'usable_type' => $usable_type,
        ])->delete();
    }
}
