<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\LmsInstitute;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SubdomainMiddleware
{
    public function handle($request, Closure $next)
    {

        if (config('app.short_url') == request()->getHost()) {
            $domain = null;
        } else {
            $domain = str_replace('.' . config('app.short_url'), '', request()->getHost());
        }

        if ($domain) {
            $institute = LmsInstitute::on(env('DB_CONNECTION'))->where('domain', $domain)->first();
        } else {
            $institute = LmsInstitute::on(env('DB_CONNECTION'))->findOrFail(1);
        }
        if (!Session::has('domain')) {
            Session::put('domain', $domain);
        }

        if (isModuleActive('LmsSaasMD')) {

            if ($institute->status == 0) {
                $maintain = collect();
                $maintain->maintenance_title = trans('saas.View Title');
                $maintain->maintenance_sub_title = trans('saas.View Sub Title');
                $maintain->maintenance_banner = HomeContents('maintenance_banner');
                return new response(view(theme('pages.maintenance'), compact('maintain')));
            }


            if (DB::connection()->getDatabaseName() != $institute->db_database) {
                DbConnect();
            }
        }

        app()->forgetInstance('institute');
        app()->instance('institute', $institute);
        return $next($request);
    }


}
