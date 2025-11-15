<?php

namespace App\Http\Controllers\Api\V2;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;

class StudentController extends Controller
{
    protected $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function studentList(Request $request): object
    {
        $rules = [
            'page' => 'nullable|integer',
            'search' => 'nullable|string',
        ];
        $request->validate($rules, validationMessage($rules));
        $response = [
            'success'   => true,
            'data'      => $this->adminRepository->studentList($request),
            'message'   => trans('api.Student list')
        ];
        return response()->json($response);
    }

    public function changeStudentStatus(Request $request): object
    {
        $rules = [
            'student_id' => 'required',
            'status' => 'nullable|boolean'
        ];

        $request->validate($rules, validationMessage($rules));
        $student = User::whereHas('role', function ($role) {
            $role->where('id', 3);
        })->where('is_active', 1)->find($request->student_id);
        if (!$student) {
            $response = [
                'success'   => false,
                'message'   => trans('api.Invalid student')
            ];
            $status = Response::HTTP_NOT_ACCEPTABLE;
        } else {
            $this->adminRepository->changeStudentStatus($request);
            $response = [
                'success'   => true,
                'message'   => trans('api.Student status changed successfully')
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    public function studentDetail(Request $request): object
    {
        $rules = ['student_id' => 'required'];
        $request->validate($rules, validationMessage($rules));
        $response = [
            'success'   => true,
            'data'      => $this->adminRepository->studentDetail($request),
            'message'   => trans('api.Student detail'),
        ];
        return response()->json($response);
    }
}
