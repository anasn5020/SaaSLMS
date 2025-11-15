<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Modules\BunnyStorage\Entities\BunnyStream;

trait BunnySettings
{


    public function getSettings()
    {
        if (saasEnv('BUNNY_COMMON_USE') == 'yes') {
            return [
                'library_id' => saasEnv('BUNNY_LIBRARY_ID'),
                'region' => saasEnv('BUNNY_REGION'),
                'zone_name' => saasEnv('BUNNY_ZONE_NAME'),
                'access_key' => saasEnv('BUNNY_ACCESS_KEY'),
                'service' => saasEnv('BUNNY_SERVICE'),
                'upload_type' => saasEnv('BUNNY_UPLOAD_TYPE'),
                'common_use' => saasEnv('BUNNY_COMMON_USE'),
                'token_authentication_key' => saasEnv('BUNNY_TOKEN_AUTHENTICATION_KEY'),
                'hostname' => saasEnv('BUNNY_HOSTNAME'),
            ];

        }
        $row = BunnyStream::whre('created_by', Auth::id())->first();
        if ($row) {
            return $row->toArray();
        }
        return [];
    }
}
