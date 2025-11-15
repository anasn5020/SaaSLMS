<?php

namespace App\Traits;

use ZipArchive;

trait UploadTheme
{
    private $files = [];

    function recurse_copy($src, $dst)
    {
        try {
            $dir = opendir($src);
            @mkdir($dst);
            while (false !== ($file = readdir($dir))) {
                if (($file != '.') && ($file != '..')) {
                    if (is_dir($src . '/' . $file)) {
                        $this->recurse_copy($src . '/' . $file, $dst . '/' . $file);
                    } else {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
            closedir($dir);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    function delete_directory($dirname)
    {
        try {
            if (is_dir($dirname)) {
                $dir_handle = opendir($dirname);
                if (!$dir_handle)
                    return false;
                while ($file = readdir($dir_handle)) {
                    if ($file != "." && $file != "..") {
                        if (!is_dir($dirname . "/" . $file))
                            unlink($dirname . "/" . $file);
                        else
                            $this->delete_directory($dirname . '/' . $file);
                    }
                }
                closedir($dir_handle);
                rmdir($dirname);
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }

    }


    function backup($src, $dst)
    {
        $zipname = storage_path('/' . 'last_update' . '.zip');
        $new_zip = new ZipArchive;

        $new_zip->open($zipname, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $this->recurse($src, $dst);
        foreach ($this->files as $file) {
            if (!is_dir($file) && file_exists($file)) {
                $new_zip->addFile($file);
            }
        }

        $new_zip->close();
    }

    function recurse($src, $dst)
    {
        $dir = opendir($src);

        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->files[] = $dst . '/' . $file;
                    $this->recurse($src . '/' . $file, $dst . '/' . $file);
                } else {
                    $file_location = str_replace('storage\app/tempUpdate', '', $src);
                    $this->files[] = $file_location . '/' . $file;
                }
            }
        }
        closedir($dir);
    }
}
