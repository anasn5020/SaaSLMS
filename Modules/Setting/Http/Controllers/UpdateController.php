<?php

namespace Modules\Setting\Http\Controllers;

use App\Traits\UploadTheme;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Setting\Entities\VersionHistory;
use ZipArchive;

class UpdateController extends Controller
{
    use UploadTheme;

    public function updateSystem(): View
    {
        $last_update = VersionHistory::latest()->first();
        return view('setting::updateSystem', compact('last_update'));
    }

    public function updateSystemSubmit(Request $request): RedirectResponse
    {
        if ($this->isDemoMode()) {
            return $this->demoErrorResponse();
        }

        if(!extension_loaded('ionCube Loader')){
            Toastr::warning('ionCube Loader required for update.');
            return back();
        }

        $request->validate(['updateFile' => ['required', 'mimes:zip']]);

        try {
            $manual_update_file_location = '.manual_update';

            $this->prepareForUpdate();

            $path = $this->storeUpdateFile($request);
            $json = $this->validateUpdateFile($path);

            $this->checkVersionCompatibility($json);


            if (isset($json['required_manual_update']) && $json['required_manual_update']){
                $manual_update = Storage::exists($manual_update_file_location) && Storage::get($manual_update_file_location) ? rtrim(Storage::get($manual_update_file_location), '\n') : false;

                if(!$manual_update){
                    $this->cleanUpTemporaryFiles();
                    Toastr::error('This update version required manual update. Before system update, please upload the manual update file and unzip to the project root folder. Please read the provided pdf file.', trans('common.Error'));
                    return redirect()->back();
                }
            }



            $this->applyUpdate($json);

            $this->finalizeUpdate($json);

            Storage::delete([$manual_update_file_location]);

            Toastr::success(trans('frontend.Your system successfully updated'), trans('common.Success'));
        } catch (Exception $e) {
            $this->handleUpdateError($e);
        }

        return redirect()->back();
    }

    private function isDemoMode(): bool
    {
        return demoCheck() || config('app.demo_mode');
    }

    private function demoErrorResponse(): RedirectResponse
    {
        Toastr::error(trans('common.For the demo version, you cannot change this'), trans('common.Failed'));
        return redirect()->back();
    }

    private function prepareForUpdate(): void
    {
        $this->allClear();
        $this->databaseBackup();
    }

    public function allClear(): bool
    {
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
        return true;
    }

    private function databaseBackup(): void
    {
        try {
            Artisan::call('backup:database',[
                '--no-interaction' => true,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    private function storeUpdateFile(Request $request): string
    {
        $updateFilePath = storage_path('app/updateFile');
        if (File::exists($updateFilePath)) {
            File::deleteDirectory($updateFilePath);
        }
        // Store the new file

        $path = $request->file('updateFile')->store('updateFile');
        $this->extractZipFile(storage_path('app/' . $path));
        return $path;
    }

    private function extractZipFile(string $filePath): void
    {
        $tempUpdatePath = storage_path('app/tempUpdate');

        // Remove existing files in the 'tempUpdate' directory
        if (File::exists($tempUpdatePath)) {
            File::deleteDirectory($tempUpdatePath);
        }


        $zip = new ZipArchive;
        if ($zip->open($filePath) === true) {
            $zip->extractTo($tempUpdatePath);
            $zip->close();
        } else {
            abort(500, 'Error! Could not open File');
        }
    }

    private function validateUpdateFile(string $path): array
    {
        $configPath = storage_path('app/tempUpdate/config.json');
        if (!File::exists($configPath)) {
            abort(500, 'The update file is corrupt.');
        }

        $json = json_decode(file_get_contents($configPath), true);

        if (empty($json) || empty($json['version']) || empty($json['release_date'])) {
            Toastr::error(trans('frontend.Config File Missing'), trans('common.Failed'));
            abort(400);
        }

        return $json;
    }

    private function checkVersionCompatibility(array $json): void
    {
        $currentVersion = Settings('system_version');
        if ($currentVersion < $json['min']) {
            Toastr::error("{$json['min']} " . trans('frontend.or greater is required for this version'), trans('common.Failed'));
            abort(400);
        }
    }

    private function applyUpdate(array $json): void
    {
        $src = storage_path('app/tempUpdate');
        $dst = base_path('/');

        // Specify protected paths (relative to the source directory)
        $protectedPaths = [
            'resources/lang/ar',
            'resources/lang/bn',
            'resources/lang/de',
            'resources/lang/en',
            'resources/lang/es',
            'resources/lang/fr',
            'resources/lang/it',
            'resources/lang/pt',
            'resources/lang/ru',
            'resources/lang/tr',
            'resources/lang/vi',
            'resources/lang/en',

            'resources/sass',
            'resources/js',
        ];
        // Remove protected paths from the temporary update directory
        $this->removeProtectedPaths($src, $protectedPaths);

        $this->backup($src, $dst);
        $this->recurse_copy($src, $dst);

        if (!empty($json['migrations'])) {
            foreach ($json['migrations'] as $migration) {
                Artisan::call('migrate', [
                    '--path' => $migration,
                    '--force' => true,
                    '--no-interaction' => true,
                    ]);
            }
        }
    }

    private function removeProtectedPaths(string $src, array $protectedPaths): void
    {
        foreach ($protectedPaths as $path) {
            $fullPath = $src . DIRECTORY_SEPARATOR . $path;

            if (File::exists($fullPath)) {
                File::deleteDirectory($fullPath); // Delete directory and its contents
            }
        }
    }

    private function finalizeUpdate(array $json): void
    {
        UpdateGeneralSetting('last_updated_date', Carbon::now());
        UpdateGeneralSetting('system_version', $json['version']);

        $this->updateVersionHistory($json);

        Storage::put('.version', $json['version']);
        $this->cleanUpTemporaryFiles();
        $this->allClear();

        $this->syncDefaultToEnglish();
    }

    private function updateVersionHistory(array $json): void
    {
        $version = VersionHistory::firstOrNew(['version' => $json['version']]);
        $version->fill([
            'release_date' => $json['release_date'],
            'url' => $json['url'],
            'notes' => $json['notes'],
            'migrations' => json_encode($json['migrations']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $version->save();
    }

    private function cleanUpTemporaryFiles(): void
    {
        File::deleteDirectory(storage_path('app/updateFile'));
        File::deleteDirectory(storage_path('app/tempUpdate'));
    }

    private function syncDefaultToEnglish(): void
    {
        $defaultLangPath = base_path('resources/lang/default');
        $targetLangPath = base_path('resources/lang/en');

        // Check if source (default) and target (en) directories exist
        if (!File::exists($defaultLangPath)) {
            throw new Exception('Default language folder does not exist.');
        }
        if (!File::exists($targetLangPath)) {
            File::makeDirectory($targetLangPath, 0755, true);
        }

        $defaultLangFiles = File::allFiles($defaultLangPath);

        foreach ($defaultLangFiles as $file) {
            $relativePath = $file->getRelativePathname();
            $defaultFilePath = $defaultLangPath . DIRECTORY_SEPARATOR . $relativePath;
            $targetFilePath = $targetLangPath . DIRECTORY_SEPARATOR . $relativePath;

            // Parse default language file
            $defaultKeys = File::exists($defaultFilePath) ? include $defaultFilePath : [];
            $defaultKeys = is_array($defaultKeys) ? $defaultKeys : [];

            // Parse target language file
            $targetKeys = File::exists($targetFilePath) ? include $targetFilePath : [];
            $targetKeys = is_array($targetKeys) ? $targetKeys : [];

            // Find missing keys
            $missingKeys = array_diff_key($defaultKeys, $targetKeys);

            if (!empty($missingKeys)) {
                // Add missing keys to the target file
                $mergedKeys = array_merge($targetKeys, $missingKeys);

                // Create target directory if it doesn't exist
                if (!File::exists(dirname($targetFilePath))) {
                    File::makeDirectory(dirname($targetFilePath), 0755, true);
                }

                // Write updated language file
                $content = "<?php\n\nreturn " . var_export($mergedKeys, true) . ";\n";
                File::put($targetFilePath, $content);
            }
        }
    }

    private function handleUpdateError(Exception $e): void
    {
        $this->cleanUpTemporaryFiles();
        $this->allClear();
        Log::error($e->getMessage());
        GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        Toastr::error(trans('frontend.Update failed. Check the logs for details.'), trans('common.Failed'));
    }

}
