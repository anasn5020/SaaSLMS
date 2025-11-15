<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class IpCheck
{

    public function handle($request, Closure $next)
    {

        if (isModuleActive('LmsSaas')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        if (!Cache::has('ipBlockList_'.$domain)) {
            $path = storage_path() . "/app/ip.json";
            if (file_exists($path)) {
                $ipAddresses = json_decode(file_get_contents($path), true);
                Cache::rememberForever('ipBlockList_'.$domain, function () use ($ipAddresses) {
                    return $ipAddresses;
                });
            }
        }
//dd($request->ip(),json_decode(file_get_contents(storage_path() . "/app/ip.json"), true));
        if (Cache::get('ipBlockList_'.$domain)) {
            $ipAddresses = Cache::get('ipBlockList_'.$domain);
            if (in_array($request->ip(), $ipAddresses)) {
                abort(403, "Your Ip Blocked By Admin");
            }
        }


        return $next($request);
    }
}
