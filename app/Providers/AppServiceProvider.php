<?php

namespace App\Providers;

use App\AboutPage;
use App\Models\LmsInstitute;
use App\OAuth\GoogleDriveProvider;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\KeysCommand;
use Modules\Chat\Entities\Status;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\FrontendManage\Entities\BecomeInstructor;
use Modules\FrontendManage\Entities\HeaderMenu;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\FrontendManage\Entities\WorkProcess;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\PermissionSection;
use Modules\StudentSetting\Entities\Institute;
use Spatie\Translatable\Facades\Translatable;
use Spatie\Valuestore\Valuestore;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        config(['google2fa.view' => theme('auth.google2fa')]);

        if (isModuleActive('Chat')) {
            $this->app->singleton('general_settings', function () {
                return Valuestore::make((base_path() . '/general_settings.json'));
            });
        }
    }

    public function boot()
    {
        Carbon::setLocale(config('app.locale'));

        if (isModuleActive('LmsSaas') || isModuleActive('LmsSaasMD')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        if (isModuleActive('LmsSaasMD')) {
            if (!Storage::has('saas_db.json')) {
                $path = Storage::path('saas_db.json');
                $data = LmsInstitute::get(['db_database', 'db_username', 'db_password', 'domain']);
                $content = [];
                foreach ($data as $row) {
                    $content[$row->domain] = [
                        "DB_DATABASE" => $row->domain == 'main' ? env('DB_DATABASE') : $row->db_database,
                        "DB_USERNAME" => $row->domain == 'main' ? env('DB_USERNAME') : $row->db_username,
                        "DB_PASSWORD" => $row->domain == 'main' ? env('DB_PASSWORD') : $row->db_password,
                    ];
                }
                file_put_contents($path, json_encode($content, JSON_PRETTY_PRINT));
            }
        }


        if (empty(SaasInstitute())) {
            redirect(env('APP_URL'))->send();
        }

        session()->put('domain', $domain);

        Paginator::useBootstrap();


        if (env('FORCE_HTTPS')) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

        Schema::defaultStringLength(191);
        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);

        try {
            if (isModuleActive('Chat')) {
                $datatable = DB::connection()->getDatabaseName();
                if ($datatable) {
                    if (hasTable('chat_notifications')) {
                        view()->composer([
                            'backend.partials.menu',
                            theme('partials._dashboard_master'),
                            theme('partials._dashboard_menu'),
                            theme('pages.fullscreen_video'),
                        ], function ($view) {
                            $notifications = DB::table('chat_notifications')->where('notifiable_id', auth()->id())
                                ->where('read_at', null)
                                ->get();

                            foreach ($notifications as $notification) {
                                $notification->data = json_decode($notification->data);
                            }
                            $notifications = $notifications->sortByDesc('created_at');

                            $view->with(['notifications_for_chat' => $notifications]);
                        });
                    }

                    view()->composer('*', function ($view) {

                        $seed = session()->get('user_status_seedable');
                        if (isModuleActive('Chat') && auth()->check() && is_null($seed)) {
                            $users = User::all();
                            foreach ($users as $user) {
                                if (hasTable('chat_statuses')) {
                                    Status::firstOrCreate([
                                        'user_id' => $user->id,
                                    ], [
                                        'user_id' => $user->id,
                                        'status' => 0
                                    ]);
                                }

                            }

                            session()->put('user_status_seedable', 'false');
                        }
                    });

                    view()->composer('*', function ($view) {
                        if (auth()->check()) {
                            $this->app->singleton('extend_view', function ($app) {
                                if (auth()->user()->role_id == 3) {
                                    return theme('layouts.dashboard_master');
                                } else {
                                    return 'backend.master';
                                }
                            });
                        }
                    });

                }
            }

            if (Settings('frontend_active_theme')) {
                $this->app->singleton('topbarSetting', function () {
                    $topbarSetting = DB::table('topbar_settings')
                        ->first();
                    return $topbarSetting;
                });
            }

            View::composer([
                theme('partials._leaderboard'),
            ], function ($view) use ($domain) {
                $data =[
                  'course_levels' => CourseLevel::select('id', 'title')->where('status', 1)->get(),
                  'courses' => Course::select('id', 'title','level')->when(request()->get('level'),function ($q){
                      $q->where('level',request()->get('level'));
                  })->where('status', 1)->get(),
                  'institutes' => Institute::select('id', 'name')->where('status', 1)->get(),
                ];
                $view->with($data);

            });

            View::composer(['backend.partials.sidebar', 'backend.partials.nav',], function ($view) use ($domain) {

                $userId = 0;
                if (Auth::check()) {
                    if (isModuleActive('Org')) {
                        $userId = Auth::user()->role_id;
                    } else {
                        $userId = Auth::id();
                    }
                }


                $data['sections'] = Cache::rememberForever('SidebarPermissionList_' . $userId . $domain, function () {
                    try {
                        $check = Permission::whereColumn('route', 'parent_route')->get();
                        if (count($check) > 0) {
                            foreach ($check as $c) {
                                $c->parent_route = null;
                                $c->save();
                            }
                        }
                        if (hasTable('permission_sections')) {

                            $query = PermissionSection::query();
                            if (!showEcommerce()) {
                                $query->where('ecommerce', '!=', 1);
                            }
                            return $query->with('activeMenus.childs', 'activeSubmenus.childs', 'permissions', 'activeMenus', 'activeSubmenus')->orderBy('position')->get();

                        } else {
                            return [];
                        }
                    } catch (Exception $e) {
                        return [];
                    }
                });

                $view->with($data);
            });

            View::composer([
                theme('partials._dashboard_menu'),
                theme('pages.fullscreen_video'),
                theme('pages.index'),
                theme('pages.courses'),
                theme('pages.free_courses'),
                theme('partials._menu'),
                theme('pages.quizzes'),
                theme('pages.classes'),
                theme('pages.search'),
                theme('components.we-tech-dashboard-page-section'),
                theme('layouts.dashboard_master'),
                theme('components.home-page-course-section')
            ], function ($view) use ($domain) {

                $data['categories'] = Cache::rememberForever('categories_' . app()->getLocale() . $domain, function () {
                    return Category::select('id', 'name', 'title', 'description', 'image', 'thumbnail', 'parent_id')
                        ->where('status', 1)
                        ->whereNull('parent_id')
                        ->withCount('courses')
                        ->orderBy('position_order', 'ASC')->with('activeSubcategories', 'childs', 'subcategories')
                        ->get();
                });


                $data['languages'] = Cache::rememberForever('languages_' . app()->getLocale() . $domain, function () {
                    if (isModuleActive('LmsSaasMD')) {
                        return DB::connection('mysql')->table('languages')->select('id', 'name', 'code', 'rtl', 'status', 'native')
                            ->where('status', 1)
                            ->get();
                    } else {
                        return DB::table('languages')->select('id', 'name', 'code', 'rtl', 'status', 'native')
                            ->where('status', 1)
                            ->where('lms_id', SaasInstitute()->id)
                            ->get();
                    }

                });
                $data['menus'] = Cache::rememberForever('menus_' . app()->getLocale() . $domain, function () {
                    try {
                        return HeaderMenu::orderBy('position', 'asc')
                            ->select('id', 'type', 'element_id', 'title', 'link', 'parent_id', 'position', 'show', 'is_newtab', 'mega_menu', 'mega_menu_column')
                            ->with('childs', 'childs.childs')
                            ->get();
                    } catch (Exception $e) {
                        return collect();
                    }
                });
                $view->with($data);
            });
            View::composer([
                'frontend.*',
                'frontend.infixlmstheme.components.breadcrumb',
                'gift::*'
            ], function ($view) {

                $selectedHeader =(int)Settings('header_style');
                $selectedFooter =(int)Settings('footer_style');
                if (!$selectedFooter){
                    $selectedFooter=1;
                }
                if (!$selectedHeader){
                    $selectedHeader=1;
                }
                $data['header_style'] = $selectedHeader;
                $data['footer_style'] = $selectedFooter;

                $data['frontendContent'] = $data['homeContent'] = (object)$this->homeContents();
                $data['about_page'] = AboutPage::getData();
                $data['become_instructor'] = BecomeInstructor::getData();
                $data['work_progress'] = WorkProcess::getData();
                $view->with($data);
            });


        } catch (Exception $e) {
            Log::info($e->getMessage());
        }

        Builder::macro('whereLike', function (string $column, string $search) {
            $like = 'LIKE';
            if (config('database.default') == 'pgsql') {
                $like = 'ILIKE';
            }
            return $this->where($column, $like, '%' . $search . '%');
        });


        Translatable::fallback(
            fallbackAny: true,
        );

        $this->bootGoogleDriveSocialite();

    }

    private function homeContents()
    {
        if (function_exists('SaasDomain')) {
            $domain = SaasDomain();
        } else {
            $domain = 'main';
        }
        return Cache::rememberForever('homeContents_' . app()->getLocale() . $domain, function () {
            return HomeContent::select(['key', 'value'])->get()->pluck('value', 'key')->toArray();
        });
    }

    private function bootGoogleDriveSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'google-drive',
            function ($app) use ($socialite) {
                $config = $app['config']['services.google-drive'];
                return $socialite->buildProvider(GoogleDriveProvider::class, $config);
            }
        );
    }
}
