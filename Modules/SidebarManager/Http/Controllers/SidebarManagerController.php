<?php

namespace Modules\SidebarManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Modules\Org\Http\Controllers\ReorderSidebarController;
use Modules\RolePermission\Entities\Permission;
use Modules\SidebarManager\Entities\Backendmenu;
use Modules\SidebarManager\Entities\BackendmenuUser;
use Modules\SidebarManager\Entities\PermissionSection;
use Modules\Store\Http\Controllers\StoreOrderResetController;

class SidebarManagerController extends Controller
{

    public function index()
    {
        if (!isModuleActive('Org')) {
            $this->oldDataSync();
        }
        try {
            $data = $this->getMenusData();
            return view('sidebarmanager::index', $data);
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    private function oldDataSync()
    {
        if (!Cache::has('oldPermissionSync' . SaasDomain())) {
            $permissions = Permission::with('parent')->select('id', 'old_name', 'old_type', 'old_parent_route', 'name', 'type', 'parent_route')->get();
            foreach ($permissions as $permission) {
                if (empty($permission->old_name)) {
                    $permission->old_name = $permission->name;
                }
                if (empty($permission->parent_route)) {
                    $permission->type = 1;
                }
                if (empty($permission->old_type)) {
                    $permission->old_type = $permission->type;
                }
                if (empty($permission->old_parent_route)) {
                    $permission->old_parent_route = $permission->parent_route;
                }
                if ($permission->parent) {
                    $permission->section_id = $permission->parent->section_id;
                }
                $permission->save();
            }
            Cache::put('oldPermissionSync' . SaasDomain(), true);
        }
    }

    private function getMenusData()
    {
        $all_menus = Permission::with('roles', 'assign')
            ->where('type', '!=', 3)
            ->where('backend', 1)->orderBy('position')->get();
        $unused_menus = $all_menus->where('menu_status', 0);
        $used_menu = $all_menus->where('menu_status', 1);
        $query = PermissionSection::query();
        if (!showEcommerce()) {
            $query->where('ecommerce', '!=', 1);
        }
        $sections = $query->with('permissions')->orderBy('position')->get();

        return compact('used_menu', 'unused_menus', 'sections', 'all_menus');
    }

    public function sectionStore(Request $request)
    {
        $code = auth()->user()->language_code;
        $rules = [
            'name.' . $code => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $section = new PermissionSection();
            foreach ((array)$request->get('name') as $key => $name) {
                $section->setTranslation('name', $key, $name);
            }
            if ($request->type!='module') {
                $section->icon= $request->get('icon')??"fas fa-th";
            }
            $section->save();

            return $this->reloadWithData();
        } catch (Exception $e) {
        }
    }

    private function reloadWithData()
    {


        $data = $this->getMenusData();
        return response()->json([
            'msg' => 'Success',
            'available_list' => (string)view('sidebarmanager::components.available_list', $data),
            'menus' => (string)view('sidebarmanager::components.components', $data),
            'live_preview' => (string)view('sidebarmanager::components.live_preview', $data)
        ], 200);
    }

    public function menuStore(Request $request)
    {

        $code = auth()->user()->language_code;

        $rules = [
            'label.' . $code => 'required',
            'route' => 'required',
//            'route' => 'required|unique:permissions',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        if (!routeIsExist($request->route)) {
            $result['errors']['route'] = trans('common.The Route not exist');
            return new JsonResponse($result, 500);
        }
        try {
            $permission = new Permission();
            foreach ((array)$request->get('label') as $key => $name) {
                $permission->setTranslation('name', $key, $name);
            }
            $permission->route = $request->route;
            $permission->type = 1;
            $permission->save();

            return $this->reloadWithData();
        } catch (Exception $e) {
        }
    }

    public function deleteSection(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->id != 1) {
                $section = PermissionSection::where('id', $request->id)->first();
                if (!empty($section->permissions)) {
                    foreach ($section->permissions as $permission) {
                        $permission->section_id = 1;
                        $permission->save();
                    }
                }
                $section->delete();
            }
            DB::commit();
            return $this->reloadWithData();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'msg' => __('common.Operation failed')
            ], 500);
        }

    }

    public function removeMenu(Request $request)
    {
        if ($request->id) {
            $menu = Permission::find($request->id);
            if ($menu) {
                $menu->menu_status = 0;
                $menu->save();
            }
        }
        return $this->reloadWithData();

    }

    public function menuEdit(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $menu = Permission::find($request->id);
        if (empty($menu->old_name)) {
            $menu->old_name = $menu->name;
        }


        foreach ((array)$request->get('label') as $key => $name) {
            $menu->setTranslation('name', $key, $name);
        }
        if ($request->type!='module') {
            $menu->icon = $request->icon;
        }
        $menu->save();

        $data = $this->getMenusData();
        return response()->json([
            'msg' => 'Success',
            'available_list' => (string)view('sidebarmanager::components.available_list', $data),
            'menus' => (string)view('sidebarmanager::components.components', $data),
            'live_preview' => (string)view('sidebarmanager::components.live_preview', $data)
        ], 200);
    }

    public function sectionEdit(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $section = PermissionSection::find($request->id);

        foreach ((array)$request->get('name') as $key => $name) {
            $section->setTranslation('name', $key, $name);
        }
        $section->icon= $request->get('icon');

        $section->save();

        $data = $this->getMenusData();
        return response()->json([
            'msg' => 'Success',
            'available_list' => (string)view('sidebarmanager::components.available_list', $data),
            'menus' => (string)view('sidebarmanager::components.components', $data),
            'live_preview' => (string)view('sidebarmanager::components.live_preview', $data)
        ], 200);
    }

    public function menuUpdate(Request $request)
    {

        $menuItemOrder = json_decode($request->get('order'));
        $this->orderMenu($menuItemOrder, 1, $request->menu_status, $request->section, null);

        if ($request->ids) {
            Permission::whereIn('id', $request->ids)->update([
                'menu_status' => 1,
            ]);
        }
        if ($request->unused_ids) {
            Permission::whereIn('id', $request->unused_ids)->update([
                'menu_status' => 0,
            ]);
        }
        return $this->reloadWithData();
    }

    private function orderMenu(array $menuItems, $level = 1, $menu_status = 1, $section = 1, $parentRoute = null)
    {
        Cache::forget('oldPermissionSync' . SaasDomain());

        foreach ($menuItems as $index => $item) {
            $menuItem = Permission::find($item->id);
            if ($menuItem) {
                $old_type = empty($menuItem->old_type) ? $menuItem->type : $menuItem->old_type;
                if ($old_type == 1) {
                    $old_parent_route = null;
                } else {
                    $old_parent_route = empty($menuItem->old_parent_route) ? $menuItem->parent_route : $menuItem->old_parent_route;
                }
//                if ($old_type != 3) {
//                    foreach ($menuItem->childs as $child) {
//                        $child->section_id = $section ?? 1;
//                        $child->old_type = $old_type;
//                        $child->old_parent_route = $old_parent_route;
//                        $child->type = 2;
//                        $child->menu_status = $menu_status ?? 1;
//                        $child->save();
//                    }
//                }


                $menuItem->update([
                    'position' => $index + 1,
                    'parent_route' => $parentRoute,
                    'section_id' => $section ?? 1,
                    'old_type' => $old_type,
                    'old_parent_route' => $old_parent_route,
                    'type' => $level,
                    'menu_status' => $menu_status ?? 1,
                ]);
                if (isset($item->children)) {
                    $this->orderMenu($item->children, 2, $menu_status, $section, $menuItem->route);

                }
            }

        }


    }

    public function sortSection(Request $request)
    {
        $request->validate([
            'ids' => 'required'
        ]);
        foreach ($request->ids as $key => $id) {
            $section = PermissionSection::where('id', $id)->first();
            if ($section) {
                $section->update([
                    'position' => $key + 1
                ]);
            }
        }
        return $this->reloadWithData();
    }

    public function resetMenu()
    {


        Cache::forget('oldPermissionSync' . SaasDomain());


        Permission::where('route', 'permission.roles.index')
            ->update([
                'name' => 'Roles',
                'old_name' => 'Roles',
            ]);

        $enrollment_childs = [
            'student.new_enroll',
            'admin.enrollLogs',
            'admin.cancelLogs'
        ];
        foreach ($enrollment_childs as $child) {

            Permission::where('route', $child)
                ->update([
                    'parent_route' => 'enrollment',
                    'old_parent_route' => 'enrollment',
                ]);
        }
        try {
            PermissionSection::where('id', '>=', 7)->delete();
            $sections = [
                [
                    'id' => 1,
                    'name' => '',
                    'ecommerce' => 0
                ],
                [
                    'id' => 2,
                    'name' => 'Users',
                    'ecommerce' => 0
                ],

                [
                    'id' => 3,
                    'name' => 'Education',
                    'ecommerce' => 0
                ],

                [
                    'id' => 4,
                    'name' => 'E-commerce',
                    'ecommerce' => 1
                ],

                [
                    'id' => 5,
                    'name' => 'Content',
                    'ecommerce' => 0
                ],
                [
                    'id' => 6,
                    'name' => 'Communication',
                    'ecommerce' => 0
                ],

                [
                    'id' => 7,
                    'name' => 'Administration',
                    'ecommerce' => 0
                ],
            ];

            $permissions = Permission::all();
            foreach ($permissions as $permission) {
                if (!empty($permission->old_name)) {
                    $permission->name = $permission->old_name;
                }
                if (!empty($permission->old_type)) {
                    $permission->type = $permission->old_type;
                }
                if (!empty($permission->old_parent_route)) {
                    $permission->parent_route = $permission->old_parent_route;
                }
                switch ($permission->route) {
                    case "students":
                        $permission->icon = 'fas fa-user';
                        break;
                    case "courses":
                        $permission->icon = 'fas fa-book';
                        break;
                    case "quiz":
                        $permission->icon = 'fas fa-question-circle';
                        break;
                    case "reports":
                        $permission->icon = 'fas fa-chart-area';
                        break;
                    case "communications":
                        $permission->icon = 'fas fa-comments';
                        break;
                    case "settings":
                        $permission->icon = 'fas fa-cogs';
                        break;
                    case "frontend_CMS":
                        $permission->icon = 'fas fa-paint-roller';
                        break;
                    case "certificate":
                        $permission->icon = 'fas fa-certificate';
                        break;
                    case "virtual-class":
                        $permission->icon = 'fas fa-vr-cardboard';
                        break;
                    case "utility":
                        $permission->icon = 'fas fa-hammer';
                        break;
                    case "org-subscription":
                        $permission->icon = 'fas fa-chalkboard';
                        break;
                    case "offline-manage":
                        $permission->icon = 'fas fa-person-booth';
                        break;
                    case "survey":
                        $permission->icon = 'fas fa-poll-h';
                        break;
                    case "forum":
                        $permission->icon = 'fas fa-users';
                        break;
                    case "org.leaderboard":
                        $permission->icon = 'fas fa-poll';
                        break;
                    case "gamification":
                        $permission->icon = 'fas fa-medal';
                        break;
                    case "comments":
                        $permission->icon = 'fas fa-comment';
                        break;
                    case "enrollment":
                        $permission->icon = 'fab fa-buysellads';
                        break;
                    case "coupons":
                        $permission->icon = 'fas fa-ticket-alt';
                        break;
                    case "coupons.inviteSettings":
                        $permission->icon = 'fas fa-users-cog';
                        break;
                    case "newsletter":
                        $permission->icon = 'fas fa-envelope-open-text';
                        break;
                    case "payments":
                        $permission->icon = 'fas fa-money-bill-alt';
                        break;

                    case "instructors":
                        $permission->icon = 'fas  fa-user-tie';
                        break;
                    case "user.manager":
                        $permission->icon = 'fas   fa-user-cog';
                        break;
                    case "blogs":
                        $permission->icon = 'fas   fa-pen-square';
                        break;
                    case "sidebar-manager.index":
                        $permission->icon = 'fas   fa-bars';
                        break;
                    case "appearance":
                        $permission->icon = 'fas   fa-paint-brush';
                        break;
                    case "backup.index":
                        $permission->icon = 'fas    fa-undo-alt';
                        break;
                    case "setting.pushNotification":
                        $permission->icon = 'fas    fa-bullhorn';
                        break;
                    case "notification":
                        $permission->icon = 'fas    fa-bell';
                        break;

                    default:
                        $permission->icon = 'fas fa-th';
                }
                $permission->menu_status = 1;
                $permission->section_id = 1;


                $permission->save();


            }


            if (isModuleActive('Org')) {
                $reorder = new ReorderSidebarController();
                $reorder->order();
            } else {

                foreach ($sections as $key => $section) {
                    PermissionSection::updateOrCreate([
                        'id' => $section['id'],
                    ], [
//                    'id' => $section['id'],
                        'position' => $key++,
                        'name' => $section['name'],
                        'ecommerce' => $section['ecommerce'],
                    ]);
                }
                $this->defaultOrder();
                if (isModuleActive('AdvanceQuiz')) {
                    $disableSidebarForAdvanceQuiz = [
                        'question-bank',
                        'question-bank-bulk',
                    ];
                    foreach ($disableSidebarForAdvanceQuiz as $disable) {
                        Permission::updateOrCreate([
                            'route' => $disable,
                        ], [
                            'menu_status' => 0,
                        ]);
                    }

                }

                if (isModuleActive('Store')) {

                    $storeMenuOrderController = new StoreOrderResetController();
                    $storeMenuOrderController->changeOrder();
                }
            }
            Artisan::call('cache:clear',[
                '--no-interaction' => true,
            ]);

            return response()->json([
                'msg' => 'Success',
                'msg_full' => trans('common.Operation successful')
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'msg' => 'Failed',
                'msg_full' => trans('common.Operation failed')
            ], 500);
        }

    }

    public function defaultOrder()
    {
        $orders = [
            'dashboard'
        ];
        $this->changeOrder($orders);

//users
        $orders = [
            'students',
            'student.student_list',
            'regular_student_import',
            'student.new_enroll',
            'student.student_field',
            'admin.enrollLogs',
            'admin.cancelLogs',
            'instructors',
            'allInstructor',
            'admin.instructor.payout',
            'user.manager',
            'staffs.index',
            'hr.department.index',
            'permission.roles.index',
            'staffs.settings',
        ];
        $this->changeOrder($orders, 2);

//education
        $orders = [
            'courses',
            'course.category',
            'getAllCourse',
            'course-level.index',
            'course.setting',
            'schoolSubject',
            'quiz',
            'question-group',
            'quiz.level.index',
            'question-bank',
            'question-bank-list',
            'question-bank-bulk',
            'online-quiz',
            'quizSetup',
            'virtual-class',
            'virtual-class.index',
            'zoom',
            'zoom.settings',

            'certificate',
            'certificate.index',
            'certificate.create',
            'certificate.fonts',
            'reports',
            'admin.reveuneList',
            'admin.reveuneListInstructor',
            'course.courseStatistics',
            'quizResult',

            'enrollment',
            'student.new_enroll',
            'admin.enrollLogs',
            'admin.cancelLogs',
            'refund.settings.create',
        ];
        $this->changeOrder($orders, 3);

        //ecommerce
        $orders = [
            'coupons',
            'coupons.manage',
            'coupons.common',
            'coupons.single',
            'coupons.personalized',
            'coupons.invite_code',
            'coupons.inviteSettings',
            'payments',
            'onlineLog',
            'offlinePayment',
            'bankPayment.index',
        ];
        $this->changeOrder($orders, 4);
//        content
        $orders = [
            'frontend_CMS',
            'frontend.headermenu',
            'frontend.menusetting',
            'frontend.sliders.index',
            'frontend.sliders.setting',
            'frontend.homeContent',
            'frontend.pageContent',
            'frontend.privacy_policy',
            'frontend.testimonials',
            'frontend.socialSetting',
            'frontend.AboutPage',
            'frontend.ContactPageContent',
            'frontend.page.index',
            'frontend.becomeInstructor',
            'frontend.sponsors.index',
            'popup-content.index',
            'footerSetting.footer.index',
            'frontend.loginpage.index',
            'frontend.faq.index',
            'frontend.customJsCss',
            'blogs',
            'blog-category.index',
            'blogs.index',
            'gamification',
            'gamification.setting',
            'gamification.badges',
            'gamification.history'

        ];
        $this->changeOrder($orders, 5);

//        communication
        $orders = [
            'communications',
            'communication.PrivateMessage',
            'comments',
            'blogs.comments.index',
            'topics.comments.index',
            'reviews',
            'topic.reviews.index',

        ];
        $this->changeOrder($orders, 6);

//        administration
        $orders = [
            'settings',
            'setting.activation',
            'setting.general_settings',
            'setting.setCommission',
            'settings.instructor_setup',
            'setting.email_setup',
            'EmailTemp',
            'paymentmethodsetting.payment_method_setting',
            'api.setting',
            'vimeosetting.index',
            'vdocipher.setting',
            'gdrive.setting',
            'setting.seo_setting',
            'languages.index',
            'currencies.index',
            'timezone.index',
            'modulemanager.index',
            'setting.updateSystem',
            'city.index',
            'setting.cookieSetting',
            'setting.cacheSetting',
            'setting.queueSetting',
            'setting.cronJob',
            'setting.captcha',
            'setting.socialLogin',
            'sidebar-manager.index',
            'setting.media-manager.index',
            'appearance',
            'appearance.themes.index',
            'appearance.themes.demo',
            'appearance.themes-customize.index',
            'newsletter',
            'newsletter.setting',
            'newsletter.mailchimp.setting',
            'newsletter.getresponse.setting',
            'newsletter.acelle.setting',
            'newsletter.subscriber',
            'notification',
            'notification_setup_list',
            'UserNotificationControll',
            'setting.pushNotification',
            'notifications.posted.index',
            'utility',
            'setting.utilities',
            'setting.preloader',
            'setting.geoLocation',
            'setting.error_log',
            'ipBlock.index',
            'backup.index',
        ];
        $this->changeOrder($orders, 7);


    }

    public function changeOrder($orders = [], $section_id = 1)
    {
        foreach ($orders as $key => $item) {
            $menu = Permission::where('route', $item)->first();
            if ($menu) {
                $menu->position = $key + 1;
                $menu->section_id = $section_id;
                $menu->save();
            }
        }
    }

    public function menuEditForm($id)
    {
        $menu = Permission::findOrFail($id);
        return view('sidebarmanager::components.edit_modal', compact('menu'));
    }

    public function sectionEditForm($id)
    {
        $section = PermissionSection::findOrFail($id);
        return view('sidebarmanager::components.edit_modal_section', compact('section'));
    }

    public function resetPermissionCache()
    {
        Cache::forget('oldPermissionSync' . SaasDomain());
        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }


}
