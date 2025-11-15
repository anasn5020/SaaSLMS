<?php

namespace Modules\ModuleManager\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadTheme;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\ModuleManager\Entities\InfixModuleManager;
use Modules\ModuleManager\Entities\Module;
use Modules\Setting\Http\Controllers\UpdateController;
use ZipArchive;

class ModuleManagerController extends Controller
{
    use UploadTheme;


    public function __construct()
    {
        AddLmsId();
        updateModuleParentRoute();
    }

    public function ModuleRefresh()
    {
        try {
//            exec('php composer.phar dump-autoload');
            Artisan::call('cache:clear',[
                '--no-interaction' => true,
            ]);
            Artisan::call('view:clear',[
                '--no-interaction' => true,
            ]);
            Artisan::call('config:clear',[
                '--no-interaction' => true,
            ]);
            Toastr::success(trans('frontend.Refresh successful'), trans('common.success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function availableModules()
    {
        $query = Module::with('verify');
//        if (config('app.demo_mode')) {
            $query->whereNotIn('name', [
                'Org',
                'OrgInstructorPolicy',
                'OrgSubscription',
                'AdvanceQuiz',
                'Homework',
                'Catalogue',
                'Group'
            ]);
//            $query->where('name','Membership');
//        }
        return $query->get();
    }

    public function ManageAddOns()
    {
        try {
            $modules = $this->availableModules();
            return view('modulemanager::manage_module', compact('modules'));
        }  catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function uploadModule(Request $request)
    {
        if (demoCheck() || config('app.demo_mode')) {
            Toastr::error(trans('common.For the demo version, you cannot change this'), trans('common.Failed'));
            return redirect()->back();
        }

        $rules = [
            'module' => 'required|mimes:zip',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {


            $path = $request->module->store('updateFile');
            $request->module->getClientOriginalName();
            $zip = new ZipArchive;
            $res = $zip->open(storage_path('app/' . $path));
            if ($res === true) {
                $zip->extractTo(storage_path('app/tempUpdate'));
                $zip->close();
            } else {
                abort(500, 'Error! Could not open File');
            }


            $src = storage_path('app/tempUpdate');

            $dir = opendir($src);

            $module = '';
            while ($file = readdir($dir)) {
                if ($file != "." && $file != "..") {
                    $module = $file;
                }
            }

            $dst = base_path('/Modules/');
            $this->recurse_copy($src, $dst);

            if (isModuleActive($module)) {
                $this->moduleMigration($module);
            }


            if (storage_path('app/updateFile')) {
                $this->delete_directory(storage_path('app/updateFile'));
            }
            if (storage_path('app/tempUpdate')) {
                $this->delete_directory(storage_path('app/tempUpdate'));
            }


            $updateController = new UpdateController();
            $updateController->allClear();
            if (function_exists('updateModuleParentRoute')) {
                updateModuleParentRoute();
            }

            if (function_exists('moduleVerify')) {
                moduleVerify($module);
            }

            Toastr::success(trans('frontend.Your module successfully uploaded'), trans('common.success'));
            return redirect()->back();


        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function moduleAddOnsEnable($name)
    {

        try {

            $module_tables = [];
            $dataPath = 'Modules/' . $name . '/' . $name . '.json';        // // Get the contents of the JSON file
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);
            $migrations = $array[$name]['migration'] ?? '';
            $version = $array[$name]['versions'][0] ?? '';
            $url = $array[$name]['url'][0] ?? '';
            $notes = $array[$name]['notes'][0] ?? '';


            DB::beginTransaction();
            $s = InfixModuleManager::where('name', $name)->first();
            if (empty($s)) {
                $s = new InfixModuleManager();
            }
            $s->name = $name;
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
            DB::commit();


            if (!empty($migrations)) {
                if (count($migrations) != 0) {
                    foreach ($migrations as $value) {
                        $module_tables[] = 'Modules/' . $name . '/Database/Migrations/' . $value;
                    }
                }

            }


            $is_module_available = 'Modules/' . $name . '/Providers/' . $name . 'ServiceProvider.php';

            if (file_exists($is_module_available)) {
                try {

                    $ModuleManage = Module::where('name', $name)->first();


                    if (!isModuleActive($name)) {
                        $ModuleManage->status = 1;
                        $ModuleManage->save();

                        if (!empty($module_tables)) {
                            foreach ($module_tables as $table) {
                                $path = $table;
                                if (file_exists($path)) {
                                    try {

//                                        $command = 'migrate:refresh --path=' . $path;

                                        Artisan::call('migrate',
                                            array(
                                                '--path' => $path,
                                                '--force' => true,
                                                '--no-interaction' => true,
                                            ));

                                        //Create lms_id column to new tables
                                        AddLmsId();

                                    } catch (\Exception $e) {
                                        Log::info($e->getMessage());
                                        $ModuleManage = Module::where('name', $name)->first();
                                        $ModuleManage->status = 0;
                                        $ModuleManage->save();
                                        $data['error'] = $e->getMessage();
                                        return response()->json($data, 200);
                                    }
                                } else {
                                    $ModuleManage = Module::where('name', $name)->first();
                                    $ModuleManage->status = 0;
                                    $ModuleManage->save();
                                    $data['error'] =  trans('common.Module File is missing, Please contact with administrator');
                                    return response()->json($data, 200);
                                }
                            }
                        }
                        $data['data'] = 'enable';
                        $data['success'] = trans('common.Operation successful');


                        $moduleCheck = \Nwidart\Modules\Facades\Module::find($name);
                        if ($moduleCheck) {
                            $moduleCheck->enable();
                        }


                        return response()->json($data, 200);
                    } else {
                        $ModuleManage = Module::where('name', $name)->first();
                        $ModuleManage->status = 0;
                        $ModuleManage->save();

                        $moduleCheck = \Nwidart\Modules\Facades\Module::find($name);
                        $moduleCheck->disable();

                        $data['data'] = 'disable';
                        $data['Module'] = $ModuleManage;
                    }


                    $data['success'] = trans('common.Operation successful');

                    return response()->json($data, 200);
                } catch (\Exception $e) {
                    Log::info($e->getMessage());
                    $data['error'] = $e->getMessage();
                    return response()->json($data, 200);
                }
            } else {
                $data['error'] =  trans('common.Module File is missing, Please contact with administrator');
                return response()->json($data, 200);
            }


        } catch (\Exception $e) {
            Log::info($e->getMessage());
            $ModuleManage = Module::where('name', $name)->first();
            $ModuleManage->status = 0;
            $ModuleManage->save();
            $moduleCheck = \Nwidart\Modules\Facades\Module::find($name);
            if ($moduleCheck) {
                $moduleCheck->disable();
            }
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }

    }


    public function FreemoduleAddOnsEnable($name)
    {


        try {

            $module_tables = [];
            $module_tables_names = [];
            $dataPath = 'Modules/' . $name . '/' . $name . '.json';        // // Get the contents of the JSON file
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);
            $migrations = $array[$name]['migration'] ?? '';


            $version = $array[$name]['versions'][0] ?? '';
            $url = $array[$name]['url'][0] ?? '';
            $notes = $array[$name]['notes'][0] ?? '';


            DB::beginTransaction();
            $s = InfixModuleManager::where('name', $name)->first();
            if (empty($s)) {
                $s = new InfixModuleManager();
            }
            $s->name = $name;
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
            DB::commit();


            if (!empty($migrations) && count($migrations) != 0) {
                foreach ($migrations as $value) {
                    $module_tables[] = 'Modules/' . $name . '/Database/Migrations/' . $value;
                }
            }


            $is_module_available = 'Modules/' . $name . '/Providers/' . $name . 'ServiceProvider.php';

            if (file_exists($is_module_available)) {
                try {

                    if (!empty($module_tables)) {
                        foreach ($module_tables as $table) {
                            $path = $table;
                            if (file_exists($path)) {
                                try {
                                    Artisan::call('migrate',
                                        array(
                                            '--path' => $path,
                                            '--force' => true,
                                            '--no-interaction' => true,
                                        ));


                                } catch (\Exception $e) {
                                    Log::info($e->getMessage());

                                }
                            }
                        }
                    }


                    $moduleCheck = \Nwidart\Modules\Facades\Module::find($name);
                    $moduleCheck->enable();


                    Module::where('name', $name)->first();


                } catch (\Exception $e) {
                    Log::info($e->getMessage());

                }
            } else {
                Log::info('module not found');
                DB::rollback();
            }


        } catch (\Exception $e) {

            Log::info($e->getMessage());
            DB::rollback();
        }

    }

    public function moduleMigration($module)
    {
        $dataPath = 'Modules/' . $module . '/' . $module . '.json';        // // Get the contents of the JSON file
        $strJsonFileContents = file_get_contents($dataPath);
        $array = json_decode($strJsonFileContents, true);
        $migrations = $array[$module]['migration'] ?? '';
        $module_tables = [];

        if (!empty($migrations) && count($migrations) != 0) {
            foreach ($migrations as $value) {
                $module_tables[] = 'Modules/' . $module . '/Database/Migrations/' . $value;
            }
        }


        $is_module_available = 'Modules/' . $module . '/Providers/' . $module . 'ServiceProvider.php';

        if (file_exists($is_module_available)) {
            try {

                if (!empty($module_tables)) {
                    foreach ($module_tables as $path) {

                        if (file_exists($path)) {
                            try {
                                $test = Artisan::call('migrate',
                                    array(
                                        '--path' => $path,
                                        '--force' => true,
                                        '--no-interaction' => true,
                                        ));
                            } catch (\Exception $e) {
                                Log::info($e->getMessage());
                            }
                        }
                    }
                }

            } catch (\Exception $e) {
                Log::info($e->getMessage());

            }
        }

        if (function_exists('updateModuleParentRoute')) {
            updateModuleParentRoute();
        }
    }

}
