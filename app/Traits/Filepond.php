<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Filepond
{

    /**
     * Converts the given path into a filepond server id
     *
     * @param string $path
     *
     * @return string
     */
    public function getServerIdFromPath($path)
    {
        return Crypt::encryptString($path);
    }

    /**
     * Converts the given filepond server id into a path
     *
     * @param string $serverId
     *
     * @return string
     */
    public function getPathFromServerId($serverId)
    {
        if (!trim($serverId)) {
            $message = 'The given file path was invalid';
            throw new \Exception($message);
        }

        $filePath = Crypt::decryptString($serverId);
        if (!Str::startsWith($filePath, $this->getBasePath())) {
            $message = 'The given file path was invalid';
            throw new \Exception($message);
        }

        return $filePath;
    }

    public function getPublicPathWithFileNameFromServerId($serverId, $driver = 'local')
    {

        try {
            $result['name'] = '';
            $result['link'] = '';
            $path = $this->getPathFromServerId($serverId);
            $file = scandir($path);

            if (isset($file[2])) {
                $ext = pathinfo($path . '\\' . $file[2], PATHINFO_EXTENSION);
                if (!$this->isFileAllow($ext)) {
                    return null;
                }
                $result['name'] = pathinfo($file[2], PATHINFO_FILENAME);
                $current_date = Carbon::now()->format('d-m-Y');
                $finalLocation = 'public/uploads/file/' . $current_date;
                if (!File::isDirectory($finalLocation)) {
                    File::makeDirectory($finalLocation, 0777, true, true);
                }

                $file_name = md5(uniqid()) . '.' . $ext;

                $uploaded_file = $path . '/' . $file[2];
                $link = $new_file = $finalLocation . '/' . $file_name;
                $result['size'] = 0;
                if ($driver == 'local') {
                    File::move($uploaded_file, $new_file);
                    $result['size'] = File::size(base_path($link)) ?? 0;
                } elseif ($driver == 's3') {
                    Storage::disk('s3')->put($new_file, file_get_contents($uploaded_file), 'public');
                    $link = Storage::disk('s3')->url($new_file);
                }


                File::deleteDirectory($path);


                $result['extension'] = $ext;
                $result['link'] = $link;

                if ($ext == 'php') {
                    return null;
                }

                return $result;

            } else {
                return null;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function getPublicPathFromServerId($serverId, $driver = 'local')
    {

        try {
            $path = $this->getPathFromServerId($serverId);
            $file = scandir($path);

            if (isset($file[2])) {
                $ext = pathinfo($path . '\\' . $file[2], PATHINFO_EXTENSION);
                if (!$this->isFileAllow($ext)) {
                    return null;
                }
                $current_date = Carbon::now()->format('d-m-Y');
                $finalLocation = 'public/uploads/file/' . $current_date;
                if (!File::isDirectory($finalLocation)) {
                    File::makeDirectory($finalLocation, 0777, true, true);
                }

                $file_name = md5(uniqid()) . '.' . $ext;

                $uploaded_file = $path . '/' . $file[2];
                $link = $new_file = $finalLocation . '/' . $file_name;

                if ($driver == 'local') {
                    File::move($uploaded_file, $new_file);

                } elseif ($driver == 's3') {
                    Storage::disk('s3')->put($new_file, file_get_contents($uploaded_file), 'public');
                    $link = Storage::disk('s3')->url($new_file);
                }


                File::deleteDirectory($path);
                return $link;

            } else {
                return null;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }


    /**
     * Get the storage base path for files.
     *
     * @return string
     */
    public function getBasePath()
    {
        return Storage::disk('local')
            ->path('filepond');
    }

    public function isFileAllow($ext)
    {
        $notAllow = ['exe', 'php', 'js', 'sh', 'bin'];
        if (in_array($ext, $notAllow)) {
            return false;
        } else {
            return true;
        }
    }
}
