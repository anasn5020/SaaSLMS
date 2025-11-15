<?php

namespace Modules\SidebarManager\Entities;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\RolePermission;

class PermissionSection extends Model
{
    protected $guarded = [];

    use HasTranslations;

    public $translatable = ['name'];

    public static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            Cache::forget('PermissionList_' . SaasDomain());
            Cache::forget('SidebarPermissionList_1' . SaasDomain());
            Cache::forget('SidebarPermissionList_2' . SaasDomain());
            Cache::forget('SidebarPermissionList_3' . SaasDomain());
            Cache::forget('SidebarPermissionList_4' . SaasDomain());
            Cache::forget('SidebarPermissionList_5' . SaasDomain());
            Cache::forget('MenuPermissionList_' . SaasDomain());
            Cache::forget('RoleList_' . SaasDomain());
            Cache::forget('oldPermissionSync' . SaasDomain());
        });
        self::updated(function ($model) {
            Cache::forget('PermissionList_' . SaasDomain());
            Cache::forget('SidebarPermissionList_1' . SaasDomain());
            Cache::forget('SidebarPermissionList_2' . SaasDomain());
            Cache::forget('SidebarPermissionList_3' . SaasDomain());
            Cache::forget('SidebarPermissionList_4' . SaasDomain());
            Cache::forget('SidebarPermissionList_5' . SaasDomain());
            Cache::forget('MenuPermissionList_' . SaasDomain());
            Cache::forget('RoleList_' . SaasDomain());
            Cache::forget('PolicyPermissionList_' . SaasDomain());
            Cache::forget('PolicyRoleList_' . SaasDomain());
            Cache::forget('oldPermissionSync' . SaasDomain());
        });
    }

    public function frontendPermissions()
    {
        $permissoins = $this->hasMany(Permission::class, 'section_id');

        $permissoins->where('menu_status', 1)
            ->where('backend', 0)
            ->whereNotIn('id',[365,366])
            ->orderBy('position');


        return $permissoins;
    }

    public function permissions()
    {


        $permissoins = $this->hasMany(Permission::class, 'section_id');

        $user = \auth()->user();

        if ($user->role_id != 1) {
            $query = RolePermission::select('permission_id');
            if (isModuleActive('OrgInstructorPolicy')) {
                $query->where('policy_id', !empty($user->policy_id) ? $user->policy_id : 0);
            } else {
                $query->where('role_id', $user->role_id);
            }
            $ids = $query->pluck('permission_id')->toArray();
            if ($user->role_id == 2 && isModuleActive('OrgInstructorPolicy')) {
                $allowRoutes = [
                    'quiz',
//                    'quiz.test-list',
//                    'quiz.add-test',
//                    'quiz.edit-test',
//                    'quiz.delete-test',
                    'quiz.mark-test',
                    'quiz.supervisor',
                    'quiz.supervisor.extraTime',
                    'quiz.supervisor.warning',
                    'quiz.supervisor.continueDoTest',
                    'quiz.supervisor.comment',
                    'set-quiz.mark-register',
                    'quizReTest'
                ];
                $new = Permission::whereIn('route', $allowRoutes)->pluck('id')->toArray();

                $ids = array_merge($ids, $new);
            }
            $permissoins->whereIn('id', $ids);
        }
        if (!showEcommerce()) {
            $permissoins->where('ecommerce', 0);
        }
        $permissoins->where('menu_status', 1)
            ->where('backend', 1)
            ->orderBy('position');
        $ignoreDynamicPage = [];
        if (hasDynamicPage()) {
            $ignoreDynamicPage = [
                'frontend.homeContent', 'frontend.privacy_policy', 'frontend.privacy_policy', 'frontend.AboutPage', 'frontend.ContactPageContent'
            ];
        }
        $setup = QuizeSetup::getData();
        if ($setup->advance_test_mode_status != 1) {
            $ignoreDynamicPage[] = 'quiz.test-list';
            $ignoreDynamicPage[] = 'quiz.mark-test';
            $ignoreDynamicPage[] = 'quiz.supervisor';
        }
        $permissoins->whereNotIn('route', $ignoreDynamicPage);

        return $permissoins;
    }

    public function activeMenus()
    {
        return $this->permissions()->where('type', 1)->where('menu_status', 1);
    }

    public function activeSubmenus()
    {
        $ignoreRoutes  = [
        'settings.instructor_setup'
    ];
        return $this->permissions()->where('type', 2)->whereNotIn('route',$ignoreRoutes)->where('menu_status', 1);
    }

    public function activeActions()
    {
        return $this->permissions()->where('type', 3)->where('menu_status', 1);
    }

    public function inActiveMenus()
    {
        return $this->permissions()->where('type', 1)->where('menu_status', 0);
    }

    public function inActiveSubmenus()
    {
        return $this->permissions()->where('type', 2)->where('menu_status', 0);
    }

    public function inActiveActions()
    {
        return $this->permissions()->where('type', 3)->where('menu_status', 0);
    }
}
