<?php

namespace App\Http\Controllers;

use App\Traits\Filepond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;


class FilepondController extends Controller
{
    use Filepond;


    public function load(Request $request)
    {
        return $request->load;
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        if (is_array($file)) {
            $path = [];
            foreach ($file as $item) {
                $filePath = $this->getBasePath() . '/upload/' . saasDomain() . '/' . uniqid();
                if (!File::isDirectory($filePath)) {
                    File::makeDirectory($filePath, 0777, true, true);
                }
                if ($item) {
                    $name = $item->getClientOriginalName();
                    if ($item->move($filePath, $name)) {
                        $path[] = $this->getServerIdFromPath($filePath);
                    }
                }
            }
            return $path;
        } else {
            $filePath = $this->getBasePath() . '/upload/' . saasDomain() . '/' . uniqid();
            if (!File::isDirectory($filePath)) {
                File::makeDirectory($filePath, 0777, true, true);
            }
            if ($file) {
                $name = $file->getClientOriginalName();
                if (!$file->move($filePath, $name)) {
                    return Response::make('Could not save file', 500);
                }
            }
            return Response::make($this->getServerIdFromPath($filePath), 200);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|int
     */
    public function chunk(Request $request)
    {
        error_reporting(E_ERROR);
        $id = $request->get('patch');

        // location of patch files
        $filePath = $this->getPathFromServerId($id);

        $fileName = $_SERVER['HTTP_UPLOAD_NAME'];
        $dir = $filePath . '/' . $fileName;

        // get patch data
        $offset = $_SERVER['HTTP_UPLOAD_OFFSET'];
        $length = $_SERVER['HTTP_UPLOAD_LENGTH'];
        // should be numeric values, else exit
        if (!is_numeric($offset) || !is_numeric($length)) {
            return http_response_code(400);
        }
        // get sanitized name

        // write patch file for this request
        file_put_contents($dir . '.patch.' . $offset, fopen('php://input', 'rb'));
        // calculate total size of patches
        $size = 0;
        $patch = glob($dir . '.patch.*');
        foreach ($patch as $filename) {
            $size += filesize($filename);
        }
        // if total size equals length of file we have gathered all patch files
        if ($size == $length) {
            // create output file
            $file_handle = fopen($dir, 'wb');
            // write patches to file
            foreach ($patch as $filename) {
                // get offset from filename
                list($dir, $offset) = explode('.patch.', $filename, 2);
                // read patch and close
                $patch_handle = fopen($filename, 'rb');
                $patch_contents = fread($patch_handle, filesize($filename));
                fclose($patch_handle);

                // apply patch
                fseek($file_handle, $offset);
                fwrite($file_handle, $patch_contents);
            }
            // remove patches
            foreach ($patch as $filename) {
                unlink($filename);
            }
            // done with file
            fclose($file_handle);
        }
        return Response::make('', 204);
    }

    /**
     * Takes the given encrypted filepath and deletes
     * it if it hasn't been tampered with
     *
     * @param Request $request
     * @return mixed
     */
    public function delete(Request $request)
    {

        try {
            $filePath = $this->getPathFromServerId($request->getContent());
            File::deleteDirectory($filePath);
        } catch (\Exception $exception) {

        }

        return Response::make('');
    }
}
