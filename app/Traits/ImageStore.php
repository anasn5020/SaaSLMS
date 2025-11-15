<?php

namespace App\Traits;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Decoders\SplFileInfoImageDecoder;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Symfony\Component\Finder\SplFileInfo;

trait ImageStore
{

    public function saveImage($image, $height = null, $width = null)
    {
        if (config('app.demo_mode')) {
            Toastr::warning('For Demo mode, some features are disabled');
            return 'public/assets/course/no_image.png';
        }

        if (!isset($image)) {
            return null;
        }

        try {
            $domain = SaasDomain();
            $current_date = Carbon::now()->format('d-m-Y');
            $upload_path = 'public/uploads/' . $domain . '/images/' . $current_date;

            // Ensure the directory exists
            File::ensureDirectoryExists($upload_path);

            // Save the image
            return $this->handleImageUpload($image, $upload_path, $height, $width);
        } catch (Exception $e) {
            Log::error('Image saving failed: ' . $e->getMessage());
            return null;
        }
    }
    private function handleImageUpload($image, $upload_path, $height, $width)
    {
        $manager = new ImageManager(new Driver());
        $extension = $image->extension();
        $fileName = uniqid();

        if ($extension === 'svg') {
            // Handle SVG images
            $img_name = $upload_path . '/' . $fileName . '.' . $extension;
            $image->move(public_path($upload_path), $fileName . '.' . $extension);
        } else {
              $img = $manager->read($image,SplFileInfoImageDecoder::class);
            // Resize image if dimensions are specified
            if ($height && $width) {
                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize(); // Prevent upsizing if original is smaller
                });
            }

            // Save the image with a unique filename
            $img_name = $upload_path . '/' . $fileName . '.' . $extension;
            $img->save($img_name);
        }

        return $img_name;
    }


    public function deleteImage($url)
    {
        if (isset($url)) {
            if (File::exists($url)) {
                File::delete($url);
                return true;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    public function saveAvatar($image, $height = null, $lenght = null)
    {
        $manager = new ImageManager(new Driver());

        if (isset($image)) {

            $current_date = Carbon::now()->format('d-m-Y');

            if (!File::isDirectory('uploads/avatar/' . $current_date)) {

                File::makeDirectory('uploads/avatar/' . $current_date, 0777, true, true);

            }

            $image_extention = 'png';

            if ($height != null && $lenght != null) {
                $img = $manager->read($image)->resize($height, $lenght);
            } else {
                $img = $manager->read($image);
            }

            $img_name = 'uploads/avatar/' . $current_date . '/' . uniqid() . '.' . $image_extention;
            $img->save($img_name);

            return $img_name;

        } else {

            return null;
        }

    }

    public static function saveImageStatic($image, $height = null, $lenght = null)
    {
        $manager = new ImageManager(new Driver());
        if (isset($image)) {
            $current_date = Carbon::now()->format('d-m-Y');

            if (!File::isDirectory('uploads/images/' . $current_date)) {
                File::makeDirectory('uploads/images/' . $current_date, 0777, true, true);
            }

            $image_extention = 'png';

            if ($height != null && $lenght != null) {
                $img = $manager->read($image)->resize($height, $lenght);
            } else {
                $img = $manager->read($image);
            }

            $img_name = 'uploads/images/' . $current_date . '/' . uniqid() . '.' . $image_extention;
            $img->save($img_name);
            return $img_name;
        } else {
            return null;
        }
    }

    public function saveFile(UploadedFile $file)
    {
        if (isset($file)) {
            $igonreFiles = ['php'];
            if (in_array($file->clientExtension(), $igonreFiles)) {
                return null;
            }
            $current_date = Carbon::now()->format('d-m-Y');
            $path = 'public/uploads/file/' . $current_date;
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $fileName1 = md5(rand(0, 9999) . '_' . time()) . '.' . $file->clientExtension();
            $file_name = $path . '/' . $fileName1;
            $file->move(public_path(str_replace('public/', '', $path)), $fileName1);
            return $file_name;
        } else {
            return null;
        }
    }

}
