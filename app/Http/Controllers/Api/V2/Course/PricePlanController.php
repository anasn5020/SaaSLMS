<?php

namespace App\Http\Controllers\Api\V2\Course;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Modules\EarlyBird\Entities\PricePlan;
use Modules\CourseSetting\Entities\Course;
use App\Repositories\Interfaces\CoursePricePlanRepositoryInterface;

class PricePlanController extends Controller
{
    private $pricePlanRepository;
    public function __construct(CoursePricePlanRepositoryInterface $pricePlanRepository)
    {
        $this->pricePlanRepository = $pricePlanRepository;
    }

    public function storePlan(Request $request): object
    {
        $rules = [
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date_format:m-d-Y',
            'end_date' => 'required|date_format:m-d-Y|after_or_equal:start_date',
            'title' => 'required|string',
            'discount' => 'required|numeric',
            'capacity' => 'nullable|numeric',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->pricePlanRepository->storePlan($request);

        $response = [
            'success' => true,
            'message' => trans('api.Price plan added successfully'),
        ];
        return response()->json($response);
    }
    public function updatePlan(Request $request): object
    {
        $rules = [
            'course_id' => 'required|exists:courses,id',
            'price_plan_id' => ['required', Rule::exists('price_plans', 'id')->where('price_planable_id', $request->course_id)],
            'start_date' => 'required|date_format:m-d-Y',
            'end_date' => 'required|date_format:m-d-Y|after_or_equal:start_date',
            'title' => 'required|string',
            'discount' => 'required|numeric',
            'capacity' => 'nullable|numeric',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->pricePlanRepository->updatePlan($request);

        $response = [
            'success' => true,
            'message' => trans('api.Price plan updated successfully'),
        ];
        return response()->json($response);
    }
    public function deletePlan(Request $request): object
    {
        $rules = [
            'course_id' => 'required|exists:courses,id',
            'price_plan_id' => ['required', Rule::exists('price_plans', 'id')->where('price_planable_id', $request->course_id)],
        ];
        $request->validate($rules, validationMessage($rules));

        $this->pricePlanRepository->deletePlan($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.Price plan deleted successfully'),
        ]);
    }

    public function virtualClassPricePlans(Request $request)
    {
        if (isModuleActive('EarlyBird')) {
            $rules = [
                'class_id' => ['required', Rule::exists('courses', 'class_id')->where('type', 3)]
            ];
            $request->validate($rules, validationMessage($rules));
            $response = [
                'success' => true,
                'data' => $this->pricePlanRepository->virtualClassPricePlans($request),
                'message' => trans('api.Getting price plan list successfuly'),
            ];
        } else {
            $response = [
                'success' => false,
                'message' => trans('api.It is a paid service'),
            ];
            $status = 401;
        }
        return response()->json($response, $status ?? 200);
    }
}
