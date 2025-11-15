<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\RolePermission\Entities\Permission;

class SearchController extends Controller
{
    function search(Request $r)
    {
        $output = '';
        try {
            if ($r->ajax()) {

                $query = $r->get('search');

                if ($query != '') {
                    $role_id = Auth::user()->role_id;
                    $query = Permission::whereLike('name', $query);
                    if ($role_id != 1) {
                        $query->join('role_permission', 'permissions.id', '=', 'role_permission.permission_id')
                            ->where('role_id', $role_id);
                    }
                    $data = $query->orderBy('permissions.id', 'desc') // Explicitly specify table
                    ->where('type', '!=', 3)
                        ->where('menu_status', 1)
                        ->where('backend', 1)
                        ->with('parent')
                        ->get();

                    if (count($data) > 0) {
                        foreach ($data as $row) {
                            $parent = $row->parent ? $row->parent->name : '';
                            if ((!$row->module || isModuleActive($row->module)) && validRouteUrl($row->route)) {
                                $output .= "<a title='" . $parent . "' href='" . validRouteUrl($row->route) . "'>" . $row->name . "</a>";
                            }
                        }
                    } else {
                        $no_result = trans('dashboard.No Results Found');
                        $output .= "<a href='#'>$no_result</a>";
                    }
                }
            }
            return $output;
        } catch (Exception $e) {
            return $output;

        }
    }
}
