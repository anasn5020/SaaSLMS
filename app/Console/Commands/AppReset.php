<?php

namespace App\Console\Commands;

use App\Models\Language;
use App\Traits\UploadTheme;
use App\User;
use Database\Seeders\EdumeThemeSeeder;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Appearance\Entities\Theme;
use Modules\Appearance\Entities\ThemeCustomize;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\FrontendManage\Entities\HeaderMenu;
use Modules\ModuleManager\Entities\InfixModuleManager;
use Modules\ModuleManager\Entities\Module;
use Modules\ModuleManager\Http\Controllers\ModuleManagerController;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\RolePermission;

class AppReset extends Command
{
    use UploadTheme;

    protected $signature = 'app:reset';


    protected $description = 'Reset Database';


    public function handle()
    {
        if (!config('app.demo_mode')) {
            $this->info('Demo mode is disabled. Exiting.');
            return false;
        }

        try {
            $startTime = now();
            $this->logProgress('Reset process started at: ' . $startTime->toDateTimeString());

            $this->startResetting();

            $this->migrateFresh();
            $this->logProgress('Database migrated (fresh).');

            $this->dbSeed();
            $this->logProgress('Database seeded.');

            $this->passportInstall();
            $this->logProgress('Passport installed.');

            $this->generateNewKey();
            $this->logProgress('Application key regenerated.');

            $this->removeUploadedImageFile();
            $this->logProgress('Uploaded image files removed.');

            $this->resetCustomCssJsFiles();
            $this->logProgress('Custom CSS/JS files reset.');

            $this->changeHomepage();
            $this->logProgress('Homepage updated.');

            $this->activeLanguages();
            $this->logProgress('Languages activated.');

            $this->modules();
            $this->logProgress('Modules configured.');

            $this->headerMenu();
            $this->logProgress('Header menu updated.');

            $this->activeThemes();
            $this->logProgress('Themes activated.');

            $this->assignAllFrontendPermisionToStudent();
            $this->logProgress('Frontend permissions assigned to students.');

            $this->utitity();
            $this->logProgress('Utility tasks completed.');

            $this->setPermission();
            $this->logProgress('Instructor role permission tasks completed.');


            $this->endResetting();

            $endTime = now();
            $this->logProgress('Reset process completed at: ' . $endTime->toDateTimeString());

        } catch (Exception $exception) {
//            Log::error('Error during reset: ' . $exception->getMessage());
            $this->error('An error occurred: ' . $exception->getMessage());
            return false;
        }

        return true;
    }

    protected function logProgress($message)
    {
        $this->info($message);
//        Log::info($message);
    }

    public function startResetting()
    {
        Storage::put('.app_resetting', '');
        Storage::put('.reset_log', now()->toDateTimeString());
    }

    protected function migrateFresh()
    {
        try {
            $modules = Module::all();
            foreach ($modules as $module) {
                $moduleCheck = \Nwidart\Modules\Facades\Module::find($module->name);

                if ($moduleCheck) {
                    $moduleCheck->disable();
                }
            }

        } catch (Exception $exception) {

        }
        Artisan::call('db:wipe', [
            '--force' => true,
            '--no-interaction' => true,
        ]);
        Artisan::call('migrate', [
            '--force' => true,
            '--no-interaction' => true,
        ]);

    }

    protected function dbSeed()
    {
        Artisan::call('db:seed', [
            '--force' => true,
            '--no-interaction' => true,
        ]);
        User::where('id',1)->update(['dark_mode' => 1]);
        Course::take(5)->update([
            'feature' => 1
        ]);
    }

    protected function passportInstall()
    {
        Artisan::call('passport:install', [
            '--no-interaction' => true,
        ]);
    }

    protected function generateNewKey()
    {
        Artisan::call('key:generate', [
            '--force' => true,
            '--no-interaction' => true,
        ]);
    }

    public function removeUploadedImageFile()
    {
        $path = 'public/uploads/main/images';
        $this->delete_directory($path);

        $path = 'public/uploads/main/file';
        $this->delete_directory($path);

        $path = 'public/database-backup';
        $this->delete_directory($path);
    }

    public function resetCustomCssJsFiles()
    {
        $css_path = 'public/frontend/infixlmstheme/css/custom.css';
        $js_path = 'public/frontend/infixlmstheme/js/custom.js';
        File::put($css_path, "");
        File::put($js_path, "");
    }

    public function changeHomepage()
    {
        $new = FrontPage::where('slug', 'home0')->first();
        if ($new) {
            $new->homepage = 1;
            $new->save();
            FrontPage::where('slug', '/')->update([
                'homepage' => 0
            ]);
        }
    }

    public function activeLanguages()
    {
        Cache::forget('LanguageList_main');
        Language::whereIn('code', ['en', 'bn', 'ar', 'fr', 'de', 'it', 'pt', 'ru', 'es', 'tr', 'vi'])->update(['status' => 1]);
    }

    public function modules()
    {
        if (!config('app.has_demo_module')) {
            return false;
        }

        $moduleManager = new ModuleManagerController();

        $modules = $moduleManager->availableModules();
        $ignore = ['SaasBranch', 'LmsSaas', 'LmsSaasMD'];
        foreach ($modules as $module) {
            $provider_file = base_path() . '/' . 'Modules/' . $module->name . '/Providers/' . $module->name . 'ServiceProvider.php';
            if (!file_exists($provider_file) || in_array($module->name, $ignore)) {
                continue;
            }

            $this->moduleInstallActive($module->name);

        }
        AddLmsId();

    }

    public function moduleInstallActive($name)
    {
        try {
            InfixModuleManager::updateOrCreate([
                'name' => $name,
            ], [
                'name' => $name,
                'email' => User::first()->email,
                'purchase_code' => time(),
                'installed_domain' => url('/'),
                'activated_date' => now(),
                'checksum' => md5(time())
            ]);

            $dataPath = 'Modules/' . $name . '/' . $name . '.json';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);
            $migrations = (array)$array[$name]['migration'] ?? [];

            $ModuleManage = Module::where('name', $name)->first();
            $ModuleManage->status = 1;
            $ModuleManage->save();

            $moduleCheck = \Nwidart\Modules\Facades\Module::find($name);
            if ($moduleCheck) {
                $moduleCheck->enable();
            }
            foreach ($migrations as $value) {
                $path = 'Modules/' . $name . '/Database/Migrations/' . $value;
                if (file_exists($path)) {
                    Artisan::call('migrate',
                        [
                            '--path' => $path,
                            '--force' => true,
                            '--no-interaction' => true,
                        ]
                    );

                }
            }


            $seeder_file = base_path() . '/' . 'Modules/' . $name . '/Database/Seeders/' . $name . 'DatabaseSeeder.php';


            if (file_exists($seeder_file)) {
                $class = "\Modules\\" . $name . "\Database\Seeders\\" . $name . "DatabaseSeeder";
                $seed = new $class();
                $seed->run();
            } else {
//                Log::error($name . ' Not Seeded');
            }
        } catch (Exception $exception) {
//            Log::error($exception->getMessage());
        }
    }

    public function headerMenu()
    {
        Model::unguard();
        HeaderMenu::truncate();
        $pages = FrontPage::all();

        $defaultHome = $pages->where('slug', '/')->first();
        $course = $pages->where('slug', '/courses')->first();
        $quiz = $pages->where('slug', '/quizzes')->first();
        $class = $pages->where('slug', '/classes')->first();


        $menus = [
            [
                'id' => 1,
                'type' => $defaultHome->is_static ? 'Static Page' : 'Dynamic Page',
                'title' => $defaultHome->title,
                'element_id' => $defaultHome->id,
                'link' => url($defaultHome->slug),
                'parent_id' => null,
                'position' => 1,
                'show' => 0,
                'is_newtab' => 0,
                'mega_menu' => 0,
                'mega_menu_column' => 2,
            ],
            [
                'id' => 2,
                'type' => $course->is_static ? 'Static Page' : 'Dynamic Page',
                'title' => $course->title,
                'element_id' => $course->id,
                'link' => url($course->slug),
                'parent_id' => null,
                'position' => 2,
                'show' => 0,
                'is_newtab' => 0,
                'mega_menu' => 0,
                'mega_menu_column' => 2,
            ], [
                'id' => 3,
                'type' => $quiz->is_static ? 'Static Page' : 'Dynamic Page',
                'title' => $quiz->title,
                'element_id' => $quiz->id,
                'link' => url($quiz->slug),
                'parent_id' => null,
                'position' => 3,
                'show' => 0,
                'is_newtab' => 0,
                'mega_menu' => 0,
                'mega_menu_column' => 2,
            ], [
                'id' => 4,
                'type' => $class->is_static ? 'Static Page' : 'Dynamic Page',
                'title' => $class->title,
                'element_id' => $class->id,
                'link' => url($class->slug),
                'parent_id' => null,
                'position' => 4,
                'show' => 0,
                'is_newtab' => 0,
                'mega_menu' => 0,
                'mega_menu_column' => 2,
            ], [
                'id' => 5,
                'type' => 'Custom Link',
                'title' => 'Others',
                'element_id' => null,
                'link' => '#',
                'parent_id' => null,
                'position' => 5,
                'show' => 0,
                'is_newtab' => 0,
                'mega_menu' => 0,
                'mega_menu_column' => 2,
            ]
        ];
        HeaderMenu::insert($menus);

        if (config('app.has_demo_module')) {
            $menu = [
                'id' => 6,
                'type' => 'Custom Link',
                'title' => 'Addons',
                'element_id' => null,
                'link' => '#',
                'parent_id' => null,
                'position' => 6,
                'show' => 0,
                'is_newtab' => 0,
                'mega_menu' => 0,
                'mega_menu_column' => 2,
            ];
            HeaderMenu::create($menu);

        }
        foreach ($pages as $key => $page) {
            if (in_array($page->slug, ['home0','home1', 'home2', 'home3', 'home4', 'home5', 'home6','home7'])) {
                $item = [
                    'type' => $page->is_static ? 'Static Page' : 'Dynamic Page',
                    'title' => $page->title,
                    'element_id' => $page->id,
                    'link' => url($page->slug),
                    'parent_id' => 1,
                    'position' => ++$key,
                    'show' => 0,
                    'is_newtab' => 0,
                    'mega_menu' => 0,
                    'mega_menu_column' => 2,
                ];
                HeaderMenu::create($item);
            } elseif (in_array($page->slug, [
                '/instructors',
                '/contact-us',
                '/about-us',
                '/become-instructor',
                '/blog',
                'certificate-verification'
            ])) {
                $item = [
                    'type' => $page->is_static ? 'Static Page' : 'Dynamic Page',
                    'title' => $page->title,
                    'element_id' => $page->id,
                    'link' => url($page->slug),
                    'parent_id' => 5,
                    'position' => ++$key,
                    'show' => 0,
                    'is_newtab' => 0,
                    'mega_menu' => 0,
                    'mega_menu_column' => 2,
                ];
                HeaderMenu::create($item);
            } elseif (in_array($page->slug, [
                    '/course/subscription',
                    '/bundle-subscription/courses',
                    '//upcoming-courses',
                    '/membership-registration',
                    '/membership',
                    '/affiliate',
                    '/appointment/tutor-finder',
                    '/appointment',
                    '/calendar-view',
                    '/offer',
                    '/forum',
                    '/store',
                ]) && config('app.has_demo_module')) {
                $item = [
                    'type' => $page->is_static ? 'Static Page' : 'Dynamic Page',
                    'title' => $page->title,
                    'element_id' => $page->id,
                    'link' => url($page->slug),
                    'parent_id' => 6,
                    'position' => ++$key,
                    'show' => 0,
                    'is_newtab' => 0,
                    'mega_menu' => 0,
                    'mega_menu_column' => 2,
                ];
                HeaderMenu::create($item);
            }
        }


    }

    public function activeThemes()
    {
        $demo_theme = config('app.demo_theme');
        if (empty($demo_theme)) {
            return false;
        }

        $str = file_get_contents(storage_path('app/theme_' . $demo_theme . '.json'));
        $json = json_decode($str, true);
        if (!$json) {
            return false;
        }

        $theme = Theme::updateOrCreate([
            'name' => $json['name'],
        ], [
            'user_id' => 1,
            'name' => $json['name'],
            'title' => $json['title'],
            'image' => $json['image'],
            'item_code' => null,
            'description' => $json['description'],
            'version' => $json['version'],
            'folder_path' => $json['folder_path'],
            'live_link' => $json['live_link'],
            'tags' => $json['tags'],
            'is_active' => $json['is_active'] ?? 0,
            'status' => $json['status'] ?? 0,
        ]);


        ThemeCustomize::updateOrCreate([
            'theme_name' => $json['name']
        ], [
            'name' => $theme->name . ' Default',
            'theme_id' => $theme->id,
            'is_default' => 1,
            'created_by' => 1,
            'primary_color' => $json['color']['primary_color'] ?? '',
            'secondary_color' => $json['color']['secondary_color'] ?? '',
            'footer_background_color' => $json['color']['footer_background_color'] ?? '',
            'footer_headline_color' => $json['color']['footer_headline_color'] ?? '',
            'footer_text_color' => $json['color']['footer_text_color'] ?? '',
            'footer_text_hover_color' => $json['color']['footer_text_hover_color'] ?? '',
        ])->first();

//active theme
        Theme::query()->update([
                'is_active' => 0
            ]
        );
        Theme::where('id', $theme->id)->update([
            'is_active' => 1
        ]);

        UpdateGeneralSetting('frontend_active_theme', $theme->name);


        //change homepage
        $new = FrontPage::where('slug', '/')->first();
        if ($new) {
            FrontPage::query()->update([
                'homepage' => 0
            ]);
            $new->homepage = 1;
            $new->save();

        }

        if ($demo_theme == 'edume') {
            $seed = new EdumeThemeSeeder();
            $seed->run();
        }


    }

    public function assignAllFrontendPermisionToStudent()
    {
        $permissions=Permission::where('backend',0)->get();
        foreach ($permissions as $permission){
            RolePermission::updateOrCreate([
                'role_id'=>3,
                'permission_id'=>$permission->id,
            ]);
        }
    }

    public function utitity()
    {

        try {
            Cache::forget('SidebarPermissionList_0main');
            Cache::forget('SidebarPermissionList_1main');
            Artisan::call('optimize:clear',[
                '--no-interaction' => true,
            ]);
            File::delete(File::glob('bootstrap/cache/*.php'));
            File::delete(File::glob('storage/framework/laravel-excel/*'));
            File::delete(File::glob('storage/framework/cache/data'));
            if (config('app.env') == 'production') {
                array_map('unlink', array_filter((array)glob(storage_path('logs/*.log'))));
            }
            array_map('unlink', array_filter((array)glob(storage_path('debugbar/*.json'))));


            envu([
                'APP_DEBUG' => env('app_env') == 'local' ? "true" : 'false',
                'FORCE_HTTPS' => "false",
            ]);
        } catch (Exception $exception) {
//            Log::error($exception->getMessage());
        }

    }

    public function setPermission()
    {
        $routes = [
            "dashboard",
            "dashboard.number_of_enrolled",
            "dashboard.number_of_subject",
            "dashboard.total_enrolled_today",
            "dashboard.total_enrolled_this_month",
            "dashboard.recent_enrolls",
            "dashboard.overview_of_courses",
            "dashboard.daily_wise_enroll",
            "dashboard.total_student_by_each_course",
            "instructors",
            "admin.instructor.payout",
            "courses",
            "course.edit",
            "courseDetails",
            "course.view",
            "course.status_update",
            "saveChapterPage",
            "chapterEdit",
            "chapterDelete",
            "course.store",
            "getAllCourse",
            "admin.reveuneListInstructor",
            "report.status_update",
            "reports",
            "quiz",
            "communications",
            "question-group",
            "question-group.store",
            "question-group.edit",
            "question-group.delete",
            "question-bank",
            "question-bank.store",
            "question-bank.edit",
            "question-bank.delete",
            "online-quiz",
            "set-quiz.store",
            "set-quiz.edit",
            "set-quiz.delete",
            "set-quiz.set-question",
            "set-quiz.manage-question",
            "set-quiz.publish-now",
            "set-quiz.mark-register",
            "communication.PrivateMessage",
            "communication.send",
            "set-quiz.quiz_result",
            "virtual-class",
            "virtual-class.index",
            "virtual-class.create",
            "virtual-class.edit",
            "virtual-class.destroy",
             "course.delete",
            "userLoginChartByDays",
            "userLoginChartByTime",
            "question-bank-bulk",
            "course.enrolled_students",
            "course.courseInvitation",
            "course.courseStudentNotify",
            "course.courseStatistics",
            "blogs",
            "blogs.index",
            "blogs.store",
            "blogs.update",
            "blogs.destroy",
            "blogs.changeStatus",
            "question-bank-list",
            "set-quiz.enrolled-student",
            "quizReTest",
            "blogs.comments.index",
            "comments",
            "blogs.comments.reply",
            "topics.comments.index",
            "topics.comments.destroy",
            "topics.comments.reply",
            "users.my_panel.index",
            "users.my_topics.index",
            "users.deposit.index",
            "users.my_certificates.index",
            "users.logged_in_devices.index",
            "users.my_referral.index",
            "users.my_purchase.index",
            "users.my_refund.index",
            "virtual-class.details",
            "setting.media-manager",
            "setting.media-manager.index",
            "setting.media-manager.create",
            "qa",
            "qa.questions",
            "qa.questions.edit",
            "qa.questions.show",
            "qa.questions.delete",
            "qa.questions.status",
        ];

        $permissions = Permission::whereIn('route', $routes)->get();
        foreach ($permissions as $permission){
            RolePermission::updateOrCreate([
                'permission_id' => $permission->id,
                'role_id' => 2,
            ]);

        }
    }

    public function endResetting()
    {
        Storage::delete('.app_resetting');

    }
}
