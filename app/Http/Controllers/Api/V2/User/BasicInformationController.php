<?php

namespace App\Http\Controllers\Api\V2\User;

use App\Traits\Filepond;
use App\Traits\UploadMedia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AuthUserRepositoryInterface;

class BasicInformationController extends Controller
{
    use UploadMedia, Filepond;
    private $authUserRepository;
    public function __construct(AuthUserRepositoryInterface $authUserRepository)
    {
        $this->authUserRepository = $authUserRepository;
    }
    public function basicInfoUpdate(Request $request): object
    {
        $rules = [
            'name' => 'required|max:150',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => [
                'nullable',
                'regex:/^([0-9\s\-\+\(\)]*)$/',
                Rule::unique('users')->ignore(\auth()->user()->id, 'id')
            ],
        ];

        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->basicInfoUpdate($request);
        $response = [
            'success' => true,
            'message' => trans('api.Profile updated successfully'),
        ];

        return response()->json($response);
    }
    public function aboutUpdate(Request $request): object
    {
        $rules = [
            'short_description' => 'nullable|max:500',
        ];
        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->aboutUpdate($request);
        $response = [
            'success' => true,
            'message' => trans('api.Profile updated successfully')
        ];

        return response()->json($response);
    }
    public function educationStore(Request $request): object
    {
        $rules = [
            'institution' => 'required|max:150',
            'degree' => 'required|max:50',
            'start_date' => 'nullable|date_format:m-d-Y',
            'end_date' => 'nullable|date_format:m-d-Y|after:start_date'
        ];
        $request->validate($rules, validationMessage($rules));

        $this->authUserRepository->educationStore($request);

        $response = [
            'success' => true,
            'message' => trans('api.Education added successfully'),
        ];

        return response()->json($response);
    }
    public function educationUpdate(Request $request): object
    {
        $rules = [
            'institution' => 'required|max:150',
            'degree' => 'required|max:50',
            'start_date' => 'nullable|date_format:m-d-Y',
            'end_date' => 'nullable|date_format:m-d-Y|after:start_date'
        ];

        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->educationUpdate($request);

        $response = [
            'success' => true,
            'message' => trans('api.Education updated successfully'),
        ];

        return response()->json($response);
    }
    public function educationDestroy(Request $request): object
    {
        $rules = [
            'education_id' => ['required', Rule::exists('user_education', 'id')->where('user_id', auth()->id())],
        ];

        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->educationDestroy($request);
        $response = [
            'success' => true,
            'message' => trans('api.Education deleted successfully')
        ];
        return response()->json($response);
    }
    public function experienceStore(Request $request): object
    {
        $rules = [
            'title' => 'required|max:150',
            'company_name' => 'required|max:190',
            'start_date' => 'required_with:end_date|nullable|date_format:m-d-Y',
            'end_date' => 'nullable|date_format:m-d-Y|after:start_date',
        ];
        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->experienceStore($request);
        return response()->json([
            'success' => true,
            'message' => trans('api.Experience added successfully'),
        ]);
    }
    public function experienceUpdate(Request $request): object
    {
        $rules = [
            'experience_id' => ['required', Rule::exists('user_experiences', 'id')->where('user_id', auth()->id())],
            'title' => 'required|max:150',
            'company_name' => 'required|max:190',
            'start_date' => 'required_with:end_date|nullable|date_format:m-d-Y',
            'end_date' => 'nullable|date_format:m-d-Y|after:start_date',
        ];
        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->experienceUpdate($request);
        return response()->json([
            'success' => true,
            'message' => trans('api.Experience updated successfully'),
        ]);
    }
    public function experienceDestroy(Request $request): object
    {
        $rules = [
            'experience_id' => ['required', Rule::exists('user_experiences', 'id')->where('user_id', auth()->id())],
        ];
        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->experienceDestroy($request);
        return response()->json([
            'success' => true,
            'message' => trans('api.Experience deleted successfully'),
        ]);
    }
    public function skillStore(Request $request): object
    {
        $rules = [
            'skills' => 'required',
        ];

        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->skillStore($request);
        return response()->json([
            'success' => true,
            'message' => trans('api.Skills updated successfully'),
        ]);
    }
    public function extraInfoUpdate(Request $request): object
    {
        $this->authUserRepository->extraInfoUpdate($request);
        return response()->json([
            'success' => true,
            'message' => trans('api.Profile updated successfully')
        ]);
    }
    public function documentUpdate(Request $request): object
    {
        $this->authUserRepository->documentUpdate($request);
        $response = [
            'success' => true,
            'message' => trans('api.Profile updated successfully'),
        ];

        return response()->json($response);
    }
    public function socialInfoUpdate(Request $request): object
    {
        $rules = [
            'instant_messaging.*.service' => 'required_with:instant_messaging.*.username',
            'instant_messaging.*.username' => 'required_with:instant_messaging.*.service'
        ];

        $request->validate($rules, validationMessage($rules));
        $this->authUserRepository->socialInfoUpdate($request);
        $response = [
            'success' => true,
            'message' => trans('api.Contact updated successfully'),
        ];

        return response()->json($response);
    }
}
