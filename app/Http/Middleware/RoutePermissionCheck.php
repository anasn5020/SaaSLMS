<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class RoutePermissionCheck
{
    public function handle($request, Closure $next, $route_name)
    {

        if (auth()->check()) {
            $user = auth()->user();
            if ($user->role_id == 1) {
                return $next($request);
            } else {
                if (Str::contains($route_name, '|')) {
                    $route_name_array = explode('|', $route_name);
                    foreach ($route_name_array as $key => $route_name) {
                        if (isModuleActive('OrgInstructorPolicy') && $user->role_id != 3) {
                            $roles = app('policy_permission_list');
                            $role = $roles->where('id', $user->policy_id)->first();

                        } else {
                            $roles = app('permission_list');
                            $role = $roles->where('id', $user->role_id)->first();
                        }

                        if ($role != null && $role->permissions->contains('route', $route_name)) {
                            return $next($request);
                        }
                    }
                    abort('403');
                } else {
                    if (isModuleActive('OrgInstructorPolicy') && $user->role_id != 3) {
                        $roles = app('policy_permission_list');
                        $role = $roles->where('id', $user->policy_id)->first();
                    } else {
                        $roles = app('permission_list');
                        $role = $roles->where('id', $user->role_id)->first();
                    }

                    if ($role != null && $role->permissions->contains('route', $route_name)) {
                        return $next($request);
                    } else {
                        abort('403');
                    }
                }
            }
        } else {
            return redirect(route('login'));
        }
        abort('403');
    }
}
