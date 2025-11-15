<?php

namespace Modules\SystemSetting\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\SystemSetting\Entities\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        try {
            $departments = Department::with('staff')->latest()->get();
            return view('systemsetting::department.index', compact('departments'));

        } catch (Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return back();
        }
    }

    public function store(Request $request)
    {
        $validate_rules = [
            'name' => ['required', 'string', 'max:255'],
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));

        try {
            Department::create($request->only('name', 'user_id', 'details'));

            return response()->json([
                'success' => trans('common.Operation successful'),
                'TableData' => $this->loadTableData(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }

    private function loadTableData()
    {
        try {
            $departments = Department::all();
            return (string)view('systemsetting::department.components.list', compact('departments'));

        } catch (Exception $e) {
            // LogActivity::errorLog($e->getMessage());
            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }

    public function update(Request $request)
    {
        $validate_rules = [
            'name' => ['required', 'string', 'max:255'],
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));
        try {
            $department = Department::find($request->id);
            $department->update($request->only('name', 'user_id', 'details'));

            return response()->json([
                'success' => trans('common.Operation successful'),
                'TableData' => $this->loadTableData(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }

    public function delete(Request $request)
    {
        $validate_rules = [
            'id' => 'required',
        ];
        $request->validate($validate_rules, validationMessage($validate_rules));


        if (demoCheckById($request->id,[1,2,3,4,5])) {
            return response()->json([
                'error' =>trans('common.For the demo version, you cannot change this')
            ]);
        }

        try {

            Department::find($request['id'])->delete();
            return response()->json([
                'success' => trans('common.Operation successful'),
                'TableData' => $this->loadTableData(),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'error' => trans('common.Something Went Wrong'),
            ]);
        }
    }
}
