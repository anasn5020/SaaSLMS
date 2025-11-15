<?php

namespace Modules\VdoCipher\Http\Controllers;

use App\Traits\Filepond;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VdoCipherController extends Controller
{
    use Filepond;

    public function setting()
    {
        try {
            return view('vdocipher::setting');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function settingUpdate(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $key = 'VDOCIPHER_API_SECRET';
            $value = $request->api_secret;
            SaasEnvSetting(SaasDomain(),$key, $value);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function uploadToVdoCipher($serverId)
    {
        try {
            $path = $this->getPathFromServerId($serverId);
            $file = scandir($path);

            if (isset($file[2])) {
                $ext = pathinfo($path . '\\' . $file[2], PATHINFO_EXTENSION);
                $current_date = Carbon::now()->format('d-m-Y');
                $finalLocation = 'public/uploads/file/' . $current_date;
                if (!File::isDirectory($finalLocation)) {
                    File::makeDirectory($finalLocation, 0777, true, true);
                }

                $file_name = md5(uniqid()) . '.' . $ext;

                $uploaded_file = $path . '/' . $file[2];
                $link = $new_file = $finalLocation . '/' . $file_name;




                File::deleteDirectory($path);
                return $link;

            } else {
                return null;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }


    public function uploadFile(){
        $responseObj = json_decode($response);
        $uploadCredentials = $responseObj->clientPayload;

// save this id in your database with status 'upload-pending'
        var_dump($responseObj->videoId);

        $filePath = '/home/username/sample-videos/The Daily Dweebs.mp4';
        $ch = curl_init($uploadCredentials->uploadLink);
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, [
            'policy' => $uploadCredentials->policy,
            'key'    => $uploadCredentials->key,
            'x-amz-signature' => $uploadCredentials->{'x-amz-signature'},
            'x-amz-algorithm' => $uploadCredentials->{'x-amz-algorithm'},
            'x-amz-date' => $uploadCredentials->{'x-amz-date'},
            'x-amz-credential' => $uploadCredentials->{'x-amz-credential'},
            'success_action_status' => 201,
            'success_action_redirect' => '',
            'file' => new \CurlFile($filePath, 'image/png', 'filename.png'),
        ]);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

// get response from the server
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($ch);

        if (!$err && $httpcode === 201) {
            // upload is successful
            // update database
            echo "upload successful";
        } else {
            // write to error logs
            echo "upload failed due to " . (($err) ? $err : $response);
        }
    }
}
