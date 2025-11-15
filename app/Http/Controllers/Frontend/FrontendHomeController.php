<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\Setting\Entities\VersionHistory;


class FrontendHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['maintenanceMode', 'onlyAppMode']);
    }

    public function index()
    {
        try {
            if (!\auth()->check()) {
                if (Settings('start_site') == 'loginpage') {
                    return redirect()->route('login');
                }
            }

            $check= Cache::rememberForever('check_homepage' . SaasDomain(), function (){
               return FrontPage::select(['slug', 'is_static'])->where('homepage', 1)->first();
            });

            if ($check && $check->slug != '/') {
                if ($check->is_static == 1) {
                    $url = url($check->slug);
                } else {
                    $url = route('frontPage', [$check->slug]);
                }

                $route = Route::getRoutes()->match(request()->create($url));

                $routeName = $route->getName();

                if ($routeName) {

                    $controllerAction = $route->getAction();
                    $controller = explode('@', $controllerAction['controller'])[0];
                    $method = explode('@', $controllerAction['controller'])[1];

                    if (class_exists($controller)) {
                        $controller = new $controller();
                        if (method_exists($controller, $method)) {
                            if ($routeName == 'frontPage') {
                                return $controller->$method($check->slug);
                            } else {
                                return $controller->$method(request());
                            }
                        }
                    }

                }


            }
            if (hasDynamicPage()) {
                $row = FrontPage::where('slug', '/')->first();
                $details = dynamicContentAppend($row->details);
                return view('aorapagebuilder::pages.show', compact('row', 'details'));
            } else {
                if (function_exists('SaasDomain')) {
                    $domain = SaasDomain();
                } else {
                    $domain = 'main';
                }
                $blocks = Cache::rememberForever('homepage_block_positions' . $domain, function () {
                    return DB::table('homepage_block_positions')->select(['id', 'block_name', 'order'])->orderBy('order', 'asc')->get();
                });

                return view(theme('pages.index'), compact('blocks'));
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function test()
    {

        dd('ok');
    }

    public function version()
    {
        return VersionHistory::select('version', 'release_date')->get()->pluck('version', 'release_date')->toArray();
    }


}
