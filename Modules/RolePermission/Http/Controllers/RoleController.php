<?php

namespace Modules\RolePermission\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Routing\Controller;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\Role;
use Modules\RolePermission\Http\Requests\RoleFormRequest;
use Modules\RolePermission\Repositories\RoleRepository;
use Modules\SidebarManager\Entities\PermissionSection;

class RoleController extends Controller
{

    public $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->middleware(['auth']);
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $data['RoleList'] = $this->roleRepository->all();
        return view('rolepermission::index', $data);
    }

    public function studentIndex()
    {
        $data['role'] = Role::with('permissions')->find(3);
        $data['sections'] = PermissionSection::orderBy('position', 'asc')->get();
        $data['permissions'] = Permission::orderBy('position', 'asc')->where('backend', 0)->get();
        return view('rolepermission::permission', $data);

    }

    public function staffIndex()
    {

        $query = Permission::where('status', 1)->where('backend', 1);
        if (!showEcommerce()) {
            $query->where('ecommerce', '!=', 1);
        }
        $PermissionList = $query->get();
        $role = Role::with('permissions')->find(4);
        $data['role'] = $role;
        $data['MainMenuList'] = $PermissionList->where('type', 1);
        $data['SubMenuList'] = $PermissionList->where('type', 2);
        $data['ActionList'] = $PermissionList->where('type', 3);
        $data['PermissionList'] = $PermissionList;
        return view('rolepermission::permission', $data);

    }

    public function create()
    {
        return view('rolepermission::create');
    }

    public function store(RoleFormRequest $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $this->roleRepository->create($request->except("_token"));
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('permission.roles.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function show($id)
    {
        $query = Permission::where('status', 1)->where('backend', 1);
        if (!showEcommerce()) {
            $query->where('ecommerce', '!=', 1);
        }
        $PermissionList = $query->get();
        $role = Role::with('permissions')->find($id);
        $data['role'] = $role;
        $data['MainMenuList'] = $PermissionList->where('type', 1);
        $data['SubMenuList'] = $PermissionList->where('type', 2);
        $data['ActionList'] = $PermissionList->where('type', 3);
        $data['PermissionList'] = $PermissionList;
        return view('rolepermission::permission', $data);
    }


    public function edit(Role $role)
    {
        try {
            $RoleList = $this->roleRepository->all();
            return view('rolepermission::index', compact('RoleList', 'role'));
//            return view('rolepermission::role', compact('RoleList', 'role'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(RoleFormRequest $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $this->roleRepository->update($request->except("_token"), $id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('permission.roles.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        try {
            $this->roleRepository->delete($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
