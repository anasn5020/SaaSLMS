<?php

namespace Modules\Appearance\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\UploadTheme;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Appearance\Entities\Theme;
use Modules\Appearance\Entities\ThemeCustomize;
use Modules\Appearance\Services\ThemeService;
use ZipArchive;

class ThemeController extends Controller
{
    use UploadTheme;

    protected $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    public function index()
    {
        try {
            $activeTheme = $this->themeService->activeOne();
            $ThemeList = $this->themeService->getAllActive();
            return view('appearance::theme.index', compact('ThemeList', 'activeTheme'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function create()
    {
        try {
            return view('appearance::theme.components.create');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function active(Request $request)
    {

        try {
            $this->themeService->isActive($request->only('id'), $request->id);

            UpdateGeneralSetting('frontend_active_theme', $this->themeService->showById($request->id)->name);

            $notification = array(
                'messege' => 'Theme Change Successfully.',
                'alert-type' => 'success'
            );
            Cache::forget('frontend_active_theme_' . SaasDomain());
            Cache::forget('getAllTheme_' . SaasDomain());
            Cache::forget('color_theme_' . SaasDomain());
            GenerateGeneralSetting(SaasDomain());
            GenerateHomeContent(SaasDomain());
            Artisan::call('optimize:clear',[
                '--no-interaction' => true,
            ]);
            return redirect(route('appearance.themes.index'))->with($notification);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request)
    {
        $message = trans('common.Theme Update Successfully');

        if (demoCheck() || config('app.demo_mode')) {
            return redirect()->back();
        }

        $rules = [
            'themeZip' => 'required|mimes:zip',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            if ($request->hasFile('themeZip')) {

                $dir = 'theme';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $path = $request->themeZip->store('theme');

                $request->themeZip->getClientOriginalName();

                $zip = new ZipArchive;
                $res = $zip->open(storage_path('app/' . $path));

                $random_dir = Str::random(10);


                $dir = explode('/', $zip->getNameIndex(0))[0] ?? $zip->getNameIndex(0);

                if ($res === true) {
                    $zip->extractTo(storage_path('app/temp/' . $random_dir . '/theme'));
                    $zip->close();
                } else {
                    return 'could not open';
                }

                $str = @file_get_contents(storage_path('app/temp/') . $random_dir . '/theme/' . $dir . '/config.json', true);

                $json = json_decode($str, true);

                if (empty($json) || empty($json['version'])) {
                    Toastr::error(trans('frontend.Config File Missing'), trans('common.Failed'));
                    return redirect()->back();
                }

                if (!empty($json['files'])) {
                    foreach ($json['files'] as $key => $directory) {
                        if ($key == 'asset_path') {
                            if (!is_dir($directory)) {
                                mkdir(base_path($directory), 0777, true);
                            }
                        }
                        if ($key == 'view_path') {
                            if (!is_dir($directory)) {
                                mkdir(base_path($directory), 0777, true);
                            }
                        }
                    }
                }

                // Create/Replace new files.
                if (!empty($json['files'])) {
                    foreach ($json['files'] as $key => $file) {

                        if ($key == 'asset_path') {
                            $src = base_path('storage/app/temp/' . $random_dir . '/theme' . '/' . $json['folder_path'] . '/asset');
                            $dst = base_path($file);
                            $this->recurse_copy($src, $dst);

                        }
                        if ($key == 'view_path') {
                            $src = base_path('storage/app/temp/' . $random_dir . '/theme' . '/' . $json['folder_path'] . '/view');
                            $dst = base_path($file);
                            $this->recurse_copy($src, $dst);
                        }
                    }
                }
                $theme = Theme::where('name', $json['name'])->first();
                if (!$theme) {
                    $message = trans('common.New Theme Upload Successfully');
                    $theme = new Theme();
                    $theme->user_id = Auth::user()->id;
                    $theme->name = $json['name'];

                    $theme->folder_path = $json['folder_path'];
                    $theme->is_active = $json['is_active'];
                    $theme->status = $json['status'];

                } else {
                    $message = trans('common.Theme Update Successfully');
                }
                $theme->title = $json['title'];
                $theme->image = $json['image'];
                $theme->item_code = $json['item_id'];
                $theme->description = $json['description'];
                $theme->version = $json['version'];
                $theme->live_link = $json['live_link'];
                $theme->tags = $json['tags'];
                $theme->save();

                $custom = ThemeCustomize::where('theme_name', $json['name'])->first();
                if (!$custom) {
                    $custom = new ThemeCustomize();
                    $custom->name = $theme->name . ' Default';
                    $custom->theme_id = $theme->id;
                    $custom->theme_name = $theme->name;
                    $custom->is_default = 1;
                    $custom->created_by = Auth::id();
                }

                $custom->primary_color = isset($json['color']) ? $json['color']['primary_color'] ?? '' : '';
                $custom->secondary_color = isset($json['color']) ? $json['color']['secondary_color'] ?? '' : '';
                $custom->footer_background_color = isset($json['color']) ? $json['color']['footer_background_color'] ?? '' : '';
                $custom->footer_headline_color = isset($json['color']) ? $json['color']['footer_headline_color'] ?? '' : '';
                $custom->footer_text_color = isset($json['color']) ? $json['color']['footer_text_color'] ?? '' : '';
                $custom->footer_text_hover_color = isset($json['color']) ? $json['color']['footer_text_hover_color'] ?? '' : '';
                $custom->save();
            }
            if (is_dir('theme') || is_dir('temp')) {

                $this->delete_directory(storage_path('app/theme'));
                $this->delete_directory(storage_path('app/temp'));
            }


            $config = 'theme_' . $theme->name . '.json';
            Storage::put($config, json_encode($json));


            Toastr::success($message, trans('common.Success'));

            return redirect(route('appearance.themes.index'));
        } catch (Exception $e) {
            if (is_dir('theme') || is_dir('temp')) {

                $this->delete_directory(storage_path('app/theme'));
                $this->delete_directory(storage_path('app/temp'));
            }

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function show($id)
    {
        try {
            $theme = $this->themeService->showById($id);
            return view('appearance::theme.components.show', compact('theme'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function destroy(Request $request)
    {
        if (demoCheck() || config('app.demo_mode')) {
            return redirect()->back();
        }
        try {
            $this->themeService->delete($request->id);

            $notification = array(
                'messege' => 'Theme Deleted Successfully.',
                'alert-type' => 'success'
            );
            return redirect(route('appearance.themes.index'))->with($notification);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function demo()
    {
        try {
            return view('appearance::theme.demo');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function demoSubmit(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $request->validate([
            'demo' => ['required', 'mimes:zip'],
        ]);
        try {


            if ($request->hasFile('demo')) {
                $path = $request->demo->store('updateFile');
                $request->demo->getClientOriginalName();
                $zip = new ZipArchive;
                $res = $zip->open(storage_path('app/' . $path));
                if ($res === true) {
                    $zip->extractTo(storage_path('app/tempUpdate'));
                    $zip->close();
                } else {
                    abort(500, 'Error! Could not open File');
                }

                $str = @file_get_contents(storage_path('app/tempUpdate/config.json'), true);
                if ($str === false) {
                    abort(500, 'The update file is corrupt.');

                }

                $json = json_decode($str, true);
                if (empty($json) || empty($json['version'])) {
                    Toastr::error(trans('frontend.Config File Missing'), trans('common.Failed'));
                    return redirect()->back();
                }

                $src = storage_path('app/tempUpdate');
                $dst = base_path('/');
                $this->recurse_copy($src, $dst);

                DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                if (isset($json['tables']) & !empty($json['tables'])) {
                    foreach ($json['tables'] as $migration) {
                        DB::table($migration)->truncate();
                    }
                }
                $sql = base_path('/demo.sql');
                if (File::exists($sql)) {
                    DB::unprepared(file_get_contents($sql));
                }
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');


            }


            if (storage_path('app/updateFile')) {
                $this->delete_directory(storage_path('app/updateFile'));
            }
            if (storage_path('app/tempUpdate')) {
                $this->delete_directory(storage_path('app/tempUpdate'));
            }
            Artisan::call('cache:clear',[
                '--no-interaction' => true,
            ]);
            Artisan::call('route:clear',[
                '--no-interaction' => true,
            ]);
            Artisan::call('view:clear',[
                '--no-interaction' => true,
            ]);
            Artisan::call('config:clear',[
                '--no-interaction' => true,
            ]);
            File::delete(File::glob('bootstrap/cache/*.php'));
            GenerateGeneralSetting(SaasDomain());
            GenerateHomeContent(SaasDomain());
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            if (storage_path('app/updateFile')) {
                $this->delete_directory(storage_path('app/updateFile'));
            }
            if (storage_path('app/tempUpdate')) {
                $this->delete_directory(storage_path('app/tempUpdate'));
            }
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
