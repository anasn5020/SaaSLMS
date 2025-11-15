<?php

namespace App\Http\Controllers\Api\V2\Membership;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\MembershipRepositoryInterface;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function __construct(private MembershipRepositoryInterface $membershipRepository)
    {
    }

    public function levels(Request $request): object
    {
        if (isModuleActive('Membership')) {
            $response = [
                'success' => true,
                'data' => $this->membershipRepository->levels($request),
                'message' => trans('api.Get membership list successfully')
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.It is a paid service')
            ];
            $status = 401;
        }
        return response()->json($response, $status ?? 200);
    }

    public function members(Request $request){
        if(isModuleActive('Membership')){
            $rules = [
                'membership_level' => 'required|exists:membership_levels,id'
            ];
            $request->validate($rules, validationMessage($rules));
            $response = [
                'success' => true,
                'data' => $this->membershipRepository->members($request),
                'message' => trans('api.Get member list successfully')
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.It is a paid service')
            ];
            $status = 401;
        }
        return response()->json($response, $status ?? 200);
    }
}
