<?php

namespace App\Http\Controllers\Api\V2\Admin;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AdminRepositoryInterface;

class DashboardController extends Controller
{
    protected $admin;

    public function __construct(AdminRepositoryInterface $admin)
    {
        $this->admin = $admin;
    }
    public function dashboard(): object
    {
        $response = [
            'success'   => true,
            'data'      => $this->admin->dashboard(),
            'message'   => trans('api.Dashboard data got successfully'),
        ];

        return response()->json($response);
    }
}
