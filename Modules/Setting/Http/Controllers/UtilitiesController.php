<?php

namespace Modules\Setting\Http\Controllers;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UtilitiesController extends Controller
{
    public function __construct()
    {
        if (!defined('STDIN')) {
            define('STDIN', fopen('php://stdin', 'r'));
        }
    }

    public function index(Request $request)
    {
        $data = [];
        if (isset($request->utilities)) {
            if ($request->utilities != "reset_demo" && appMode()) {
                Toastr::error(trans('common.For the demo version, you cannot change this'), trans('common.Failed'));
                return redirect()->back();
            }

            $utility = $request->utilities;
            if ($utility == "optimize_clear") {
                Artisan::call('optimize:clear',[
                    '--no-interaction' => true,
                ]);
                File::delete(File::glob('bootstrap/cache/*.php'));
                File::delete(File::glob('storage/framework/laravel-excel/*'));

            } elseif ($utility == "clear_log") {
                array_map('unlink', array_filter((array)glob(storage_path('logs/*.log'))));
                array_map('unlink', array_filter((array)glob(storage_path('debugbar/*.json'))));

            } elseif ($utility == "change_debug") {
                envu([
                    'APP_DEBUG' => env('APP_DEBUG') ? "false" : "true"
                ]);
            } elseif ($utility == "force_https") {
                putEnvConfigration('FORCE_HTTPS', env('FORCE_HTTPS') ? "false" : "true");

            } elseif ($utility == "passport") {
//                Artisan::call('migrate', [
//                    '--path' => 'vendor/laravel/passport/database/migrations',
//                    '--force' => true,
//
//                ]);
                Artisan::call('passport:install',[
                    '--no-interaction' => true,
                ]);
            } elseif ($utility == "reset_demo" && config('app.demo_mode')) {
                Artisan::call('app:reset',[
                    '--no-interaction' => true,
                ]);
            } else {
                Toastr::error(trans('common.Invalid Command'), trans('common.Failed'));
                return redirect()->back();
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();

        }
        $hasPassportInstall = false;
        if (Schema::hasTable('oauth_clients')) {
            $count = DB::table('oauth_clients')->count();
            if ($count != 0) {
                $hasPassportInstall = true;
            }
        }
        $data['hasPassportInstall'] = $hasPassportInstall;
        return view('setting::utilities', $data);
    }

    public function resetDatabase(Request $request)
    {

        try {
            if ($request->password == "") {
                Toastr::error(__('common.enter_your_password'));
            } elseif (Hash::check($request->password, auth()->user()->password)) {
                $this->freshDatabase();
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            } else {
                Toastr::error(__('common.Password did not match with your account password'));
            }
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error(trans('common.Operation Failed'), trans('common.Error'));
            return redirect()->back();
        }

    }

    public function freshDatabase()
    {
        $user = DB::table('users')->where('id', 1)->first();
        Artisan::call('db:wipe', [
            '--force' => true,
            '--no-interaction' => true,
            ]);
        Artisan::call('migrate', [
            '--force' => true,
            '--no-interaction' => true,
            ]);
        User::where('id', 1)->update(collect($user)->toArray());
        UpdateGeneralSetting('system_domain', env('APP_URL'));
        GenerateHomeContent(SaasDomain());
    }

    public function importDemoDatabase(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            if ($request->password == "") {
                Toastr::error(__('common.enter_your_password'));
            } elseif (Hash::check($request->password, auth()->user()->password)) {
                $this->freshDatabase();
                Artisan::call('db:seed', [
                    '--force' => true,
                    '--no-interaction' => true,
                ]);

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            } else {
                Toastr::error(__('common.Password did not match with your account password'));
            }
            return back();
        } catch (Exception $e) {
            Toastr::error(trans('common.Operation Failed'), trans('common.Error'));
            return redirect()->back();
        }

    }

}
