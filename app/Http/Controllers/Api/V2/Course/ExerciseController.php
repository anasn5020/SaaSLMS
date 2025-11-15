<?php

namespace App\Http\Controllers\Api\V2\Course;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CourseExerciseRepositoryInterface;
use Illuminate\Validation\Rule;

class ExerciseController extends Controller
{
    private $exerciseRepo;

    public function __construct(CourseExerciseRepositoryInterface $exerciseRepo)
    {
        $this->exerciseRepo = $exerciseRepo;
    }

    public function store(Request $request): object
    {
        session()->flash('type', 'files');
        $rules = ['file' => 'required'];
        $request->validate($rules, validationMessage($rules));

        $request->merge([
            'id' => $request->course_id,
            'fileName' => $request->file_name,
            'lock' => $request->locked,
        ]);

        $store = $this->exerciseRepo->store($request);

        if($store){
            return response()->json([
                'success' => true,
                'message' => trans('api.File added successfully'),
            ]);
        }else{
            return response()->json([
                'success' => true,
                'message' => trans('api.File cannot add'),
            ], 422);
        }
    }

    public function update(Request $request): object
    {
        session()->flash('type', 'files');
        $rules = [
            'file_id' => ['required',Rule::exists('course_exercises','id')->where('course_id', $request->course_id)]
        ];
        $request->validate($rules, validationMessage($rules));

        $request->merge([
            'id' => $request->file_id,
            'fileName' => $request->file_name,
            'lock' => $request->locked,
        ]);

        $this->exerciseRepo->update($request);

        return response()->json([
            'success' => true,
            'message' => trans('api.File updated successfully'),
        ]);
    }
    public function delete(Request $request): object
    {
        return $this->exerciseRepo->delete($request);
    }
}
