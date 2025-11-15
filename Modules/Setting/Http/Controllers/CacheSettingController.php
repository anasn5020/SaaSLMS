<?php

namespace Modules\Setting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CacheSettingController extends Controller
{

    public function index()
    {
        $driver = env('CACHE_DRIVER');
        return view('setting::cache_setting', compact('driver'));
    }


    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {

            putEnvConfigration('CACHE_DRIVER', $request->driver);

            putEnvConfigration('REDIS_HOST', $request->redis_host);
            putEnvConfigration('REDIS_PASSWORD', $request->redis_password);
            putEnvConfigration('REDIS_PORT', $request->redis_port);


            putEnvConfigration('MEMCACHED_PERSISTENT_ID', $request->memcached_persistent_id);
            putEnvConfigration('MEMCACHED_HOST', $request->memcached_host);
            putEnvConfigration('MEMCACHED_PASSWORD', $request->memcached_password);
            putEnvConfigration('MEMCACHED_PORT', $request->memcached_port);
            putEnvConfigration('MEMCACHED_USERNAME', $request->memcached_username);


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }
}
