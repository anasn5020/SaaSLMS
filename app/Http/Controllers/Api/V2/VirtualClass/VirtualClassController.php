<?php

namespace App\Http\Controllers\Api\V2\VirtualClass;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Modules\VirtualClass\Entities\VirtualClass;
use App\Repositories\Interfaces\VirtualClassRepositoryInterface;

class VirtualClassController extends Controller
{
    private $virtualClassRepository;
    public function __construct(VirtualClassRepositoryInterface $virtualClassRepository)
    {
        $this->virtualClassRepository = $virtualClassRepository;
    }
    public function store(Request $request): object
    {
        if (saasPlanCheck('meeting')) {
            return response()->json(['success' => false, 'message' => 'You have reached valid class limit']);
        }
        if (demoCheck()) {
            return response()->json(['message' => trans('common.For the demo version, you cannot change this')],403);
        }
        $code = auth()->user()->language_code ?? 'en';

        $rules = [
            'title.' . $code => 'required|max:255',
            'duration' => 'required',
            'category' => 'required',
            'lang_id' => 'required',
            'host' => 'required',
            'time' => 'required',
            'start_date' => 'required|date_format:m-d-Y',
            'recurring_type' => 'required_if:is_recurring,1',
            'recurring_repeat_count' => 'required_if:is_recurring,1',
            'recurring_days' => 'required_if:recurring_type,2',
            'end_date' => 'required_if:is_recurring,1|date_format:m-d-Y',
            'password' => 'required_if:host,==,Zoom',
            'attendee_password' => 'required_if:host,==,BBB',
            'moderator_password' => 'required_if:host,==,BBB',
            'attached_file' => 'nullable|mimes:jpeg,png,jpg,doc,docx,pdf,xls,xlsx',
        ];
        if (!$request->free && showEcommerce()) {
            $rules = [
                'fees' => 'required'
            ];
        }
        $request->validate($rules, validationMessage($rules));

        $this->virtualClassRepository->store($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Class added successfully')
        ]);
    }
    public function instructors(Request $request): object
    {
        $instructors = $this->virtualClassRepository->instructors($request);
        if (empty($instructors)) {
            $response = [
                'success'   => false,
                'message'   => trans('api.Data not found')
            ];
            $status = 404;
        } else {
            $response = [
                'success'   => true,
                'data'      => $instructors,
                'message'   => trans('api.Operation successful')
            ];
        }
        return response()->json($response, $status ?? 200);
    }

    public function classDetail(Request $request): object
    {
        $rules = ['class_id' => 'required|exists:virtual_classes,id'];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success'   => true,
            'data'      => $this->virtualClassRepository->classDetail($request),
            'message'   => trans('api.Getting class details successfully'),
        ]);
    }

    public function classSchedules(Request $request): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->virtualClassRepository->classSchedules($request),
            'message'   => trans('api.Getting class list successfully'),
        ]);
    }

    public function updateClass(Request $request): object
    {
        if (demoCheck()) {
            return response()->json(['message' => trans('common.For the demo version, you cannot change this')],403);
        }

        $code = auth()->user()->language_code ?? 'en';

        $rules = [
            'title.' . $code => 'required|max:255',
            'duration' => 'required',
            'category' => 'required',
            'lang_id' => 'required',
            'time' => 'required',
            'start_date' => 'required|date_format:m-d-Y',
            'recurring_type' => 'required_if:is_recurring,1',
            'recurring_repeat_count' => 'required_if:is_recurring,1',
            'recurring_days' => 'required_if:recurring_type,2',
            'end_date' => 'required_if:is_recurring,1|date_format:m-d-Y',
        ];
        if (!$request->free && showEcommerce()) {
            $rules = [
                'fees' => 'required',
            ];
        }
        $request->validate($rules, validationMessage($rules));
        $this->virtualClassRepository->updateClass($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Class updated successfully'),
        ]);
    }

    public function certificateTypes(): object
    {
        return response()->json([
            'success'   => true,
            'data'      => $this->virtualClassRepository->certificateTypes(),
            'message'   => trans('api.Operation successful')
        ]);
    }
    public function classList(Request $request): object
    {
        if (auth()->user()->role_id == 3) {
            return response()->json(['error' => 'Permission Denied'], 403);
        } else if (!auth()->check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        } else {
            return response()->json([
                'success'   => true,
                'data'      => $this->virtualClassRepository->classList($request),
                'message'   => trans('api.Getting class list successfully'),
            ]);
        }
    }
    public function changeStatus(Request $request): object
    {
        $rules = [
            'class_id' => 'required|exists:virtual_classes,id',
            'status' => 'nullable|boolean'
        ];
        $request->validate($rules, validationMessage($rules));

        if (appMode()) {
            return response()->json(['message' => trans('common.For the demo version, you cannot change this')], 403);
        } else if (auth()->user()->role_id == 3) {
            return response()->json(['error' => 'Permission Denied'], 403);
        } else if (!auth()->check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        } else {
            $this->virtualClassRepository->changeStatus($request);
            return response()->json([
                'success'   => true,
                'message'   => trans('api.Class status changed successfully'),
            ]);
        }
    }

    public function deleteClass(Request $request): object
    {
        $rules = ['class_id' => 'required|exists:virtual_classes,id'];
        $request->validate($rules, validationMessage($rules));

        $virtualClass = VirtualClass::find($request->class_id);
        $enrolls = $virtualClass->course->enrolls;

        if (appMode()) {
            return response()->json(['message' => trans('common.For the demo version, you cannot change this')], 403);
        } else if (auth()->user()->role_id == 3) {
            return response()->json(['error' => 'Permission Denied'], 403);
        } else if (!auth()->check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        } else if ($enrolls->isNotEmpty()) {
            return response()->json(['success' => false, 'message' => 'Course Already Enrolled By ' . $enrolls->count() . ' Student'], 403);
        } else {
            $this->virtualClassRepository->deleteClass($request);
            return response()->json([
                'success'   => true,
                'message'   => trans('api.Class deleted successfully'),
            ]);
        }
    }

    public function deleteSchedule(Request $request): object
    {
        if(demoCheck()){
            return response()->json(['message'=> trans('common.For the demo version, you cannot change this')],403);
        }
        $rules = ['class_id' => 'required|exists:virtual_classes,id'];

        $class = VirtualClass::find($request->class_id);
        switch ($class->host) {
            case 'Zoom':
                $rules = [
                    'schedule_id' => ['required', Rule::exists('zoom_meetings', 'id')->where('class_id', $request->class_id)],
                ];
                break;
            case 'BBB':
                $rules = [
                    'schedule_id' => ['required', Rule::exists('bbb_meetings', 'id')->where('class_id', $request->class_id)],
                ];
                break;
            case 'Jitsi':
                $rules = [
                    'schedule_id' => ['required', Rule::exists('jitsi_meetings', 'id')->where('class_id', $request->class_id)],
                ];
                break;
            case 'InAppLiveClass':
                $rules = [
                    'schedule_id' => ['required', Rule::exists('in_app_live_class_meetings', 'id')->where('class_id', $request->class_id)],
                ];
                break;
            default:
                $rules = [
                    'schedule_id' => ['required', Rule::exists('custom_meetings', 'id')->where('class_id', $request->class_id)],
                ];
                break;
        }
        $request->validate($rules, validationMessage($rules));

        $this->virtualClassRepository->deleteSchedule($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Class deleted successfully'),
        ]);
    }

    public function addPricePlan(Request $request): object
    {
        if (isModuleActive('EarlyBird')) {
            $rules = ['class_id' => 'required|exists:virtual_classes,id'];
            $request->validate($rules, validationMessage($rules));
            $this->virtualClassRepository->addPricePlan($request);
            $response = [
                'success' => true,
                'message' => trans('api.Price plan added successfully')
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
    public function deletePricePlan(Request $request): object
    {
        if (isModuleActive('EarlyBird')) {
            $rules = [
                'class_id' => 'required|exists:virtual_classes,id',
                'price_plan_id' => 'required|exists:price_plans,id',
            ];
            $request->validate($rules, validationMessage($rules));
            $this->virtualClassRepository->deletePricePlan($request);
            $response = [
                'success' => true,
                'message' => trans('api.Price plan deleted successfully')
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

    public function updatePricePlan(Request $request): object
    {
        if (isModuleActive('EarlyBird')) {
            $rules = [
                'class_id' => 'required|exists:virtual_classes,id',
                'price_plan_id' => 'required|exists:price_plans,id',
            ];
            $request->validate($rules, validationMessage($rules));
            $this->virtualClassRepository->updatePricePlan($request);
            $response = [
                'success' => true,
                'message' => trans('api.Price plan updated successfully')
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
