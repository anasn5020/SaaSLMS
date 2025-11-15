<?php

namespace App\Http\Controllers\Api\V2\Course;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\CourseEnrolled;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class CourseController extends Controller
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function courses(Request $request): object
    {
        $rules = [
            'page' => 'nullable|integer',
            'type' => 'nullable|integer|in:1,2',
            'search' => 'nullable|string',
            'per_page' => 'nullable|integer',
        ];

        $request->validate($rules, validationMessage($rules));

        $response = [
            'success'   => true,
            'data'      => $this->courseRepository->courses($request),
            'message'   => trans('api.Get course list successfully'),
        ];
        return response()->json($response);
    }

    public function changeStatus(Request $request): object
    {
        $rules = [
            'id' => 'required|integer',
            'status' => 'nullable|boolean',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->courseRepository->changeStatus($request);

        $response = [
            'success'   => true,
            'message'   => trans('api.Course status changed successfully'),
        ];
        return response()->json($response);
    }

    public function detail(Request $request): object
    {
        $rules = [
            'course_id' => ['required', Rule::exists('courses', 'id')->whereIn('type', [1, 2])]
        ];
        $request->validate($rules, validationMessage($rules));

        return response()->json([
            'success' => true,
            'data' => $this->courseRepository->courseDetail($request),
            'message' => trans('api.Get course details successfully')
        ]);
    }

    public function update(Request $request): object
    {
        session()->flash('type', 'update');
        session()->flash('id', $request->id);

        if (demoCheck()) {
            return response()->json(['message' => trans('api.Demo has no access for this action.')], 403);
        }
        session()->flash('type', 'courseDetails');
        $rules = [
            'title.*' => 'required|max:255',
            'type' => 'required',
            'language_id' => 'required',
        ];
        $request->validate($rules, validationMessage($rules));

        $request->merge([
            'language'          => $request->language_id,
            'category'          => $request->category_id,
            'sub_category'      => $request->subcategory_id,
            'is_free'           => $request->free_course,
            'complete_order'    => $request->sequence,
            'discount_course'   => $request->is_discount,
            'iap'               => $request->in_app_purchase_course,
            'iap_product_id'    => $request->in_app_purchase_product_id,
            'scope'             => $request->view_scope,
            'drip'              => $request->drip_content,
            'access_limit'      => $request->access_limit_in_days,
        ]);

        if ($request->type == 1) {
            $rules = [
                'duration' => 'nullable',
                'level' => 'required',
                'category' => 'required',
            ];
            $request->validate($rules, validationMessage($rules));

            if (isset($request->show_overview_media)) {
                if ($request->get('host') == "Vimeo") {
                    $rules = [
                        'vimeo' => 'required',
                    ];
                    $request->validate($rules, validationMessage($rules));
                } elseif ($request->get('host') == "VdoCipher") {
                    $rules = [
                        'vdocipher' => 'required',
                    ];
                    $request->validate($rules, validationMessage($rules));
                } elseif ($request->get('host') == "Youtube") {
                    $rules = [
                        'trailer_link' => 'required'
                    ];
                    $request->validate($rules, validationMessage($rules));
                }
            }
        }

        $this->courseRepository->courseUpdate($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Course updated successfully')
        ]);
    }

    public function categories(Request $request): object
    {
        $response = [
            'success'   => true,
            'data'      => $this->courseRepository->categories($request),
            'message'   => trans('api.Get category list successfully')
        ];
        return response()->json($response);
    }

    public function subcategories(Request $request): object
    {
        $rules = [
            'category_id' => 'required|exists:categories,id'
        ];
        $request->validate($rules, validationMessage($rules));

        $response = [
            'success'   => true,
            'data'      => $this->courseRepository->subcategories($request),
            'message'   => trans('api.Get subcategory list successfully')
        ];
        return response()->json($response);
    }

    public function storeCourse(Request $request)
    {
        $rules = [
            'title.*' => 'required|max:255',
            'type' => 'required',
            'language_id' => 'required',
            'duration' => 'nullable',
        ];

        if ($request->is_upcoming_course) {
            $rules["publish_date"] = "required|date_format:m-d-Y|after:today";
        }

        if ($request->is_discount == 1) {
            $rules["booking_amount"] = "required_if:is_allow_prebooking,1|nullable|numeric|lte:discount_price";
        } else {
            $rules["booking_amount"] = "required_if:is_allow_prebooking,1|nullable|numeric|lte:price";
        }

        $request->validate($rules, validationMessage($rules));
        $request->merge([
            'language' => $request->language_id,
            'category' => $request->category_id,
            'sub_category' => $request->subcategory_id,
            'is_free' => $request->free_course,
            'complete_order' => $request->sequence,
            'discount_course' => $request->is_discount,
            'iap' => $request->in_app_purchase_course,
            'iap_product_id' => $request->in_app_purchase_product_id,
            'scope' => $request->view_scope,
            'drip' => $request->drip_content,
            'access_limit' => $request->access_limit_in_days,
        ]);

        if ($request->type == 1) {
            $rules = [
                'level' => 'required',
                'category' => 'required',
                // 'host' => 'required',
            ];
            $request->validate($rules, validationMessage($rules));

            if (isset($request->show_overview_media)) {

                $rules = [
                    'host' => 'required',
                ];
                $request->validate($rules, validationMessage($rules));

                if ($request->get('host') == "Vimeo") {
                    $rules = [
                        'vimeo' => 'required',
                    ];
                    $request->validate($rules, validationMessage($rules));
                } elseif ($request->get('host') == "VdoCipher") {
                    $rules = [
                        'vdocipher' => 'required',
                    ];
                    $request->validate($rules, validationMessage($rules));
                } elseif ($request->get('host') == "Youtube") {
                    $rules = [
                        'trailer_link' => 'required'
                    ];
                    $request->validate($rules, validationMessage($rules));
                }
            }
        }

        $this->courseRepository->storeCourse($request);

        $response = [
            'success'   => true,
            'message'   => trans('api.Course added successfully'),
        ];

        return response()->json($response);
    }

    public function levels(Request $request): object
    {
        $response = [
            'success'   => true,
            'data'      => $this->courseRepository->levels($request),
            'message'   => trans('api.Get level list successfully'),
        ];

        return response()->json($response);
    }

    public function chapterRearrange(Request $request): object
    {
        $rules = [
            'course_id' => ['required', Rule::exists('courses', 'id')
                ->when($user = auth()->user(), function ($course) use ($user) {
                    if ($user->role_id == 2) {
                        $course->where('user_id', $user->id);
                    } elseif ($user->role_id == 1) {
                        $course;
                    }
                })],
        ];
        $request->validate($rules, validationMessage($rules));

        $this->courseRepository->chapterRearrange($request);

        return response()->json([
            'success'   => true,
            'message'   => trans('api.Chapter order changed successfully'),
        ]);
    }

    public function certificateList(): object
    {
        $response = [
            'success'   => true,
            'data'      => $this->courseRepository->certificateList(),
            'message'   => trans('api.Getting certificate list successfully'),
        ];

        return response()->json($response);
    }

    public function assignCertificate(Request $request): object
    {
        return $this->courseRepository->assignCertificate($request);
    }

    public function categoryDetail(Request $request)
    {
        $rules = [
            'category_id' => 'required|exists:categories,id'
        ];
        $request->validate($rules, validationMessage($rules));

        $response = [
            'success' => true,
            'data' => $this->courseRepository->categoryDetail($request),
            'message' => trans('api.Get category details successfully'),
        ];

        return response()->json($response);
    }
    public function categoryStore(Request $request): object
    {
        $rules = [
            'name.*' => 'required|max:255',
        ];

        $request->validate($rules, validationMessage($rules));

        $this->courseRepository->categoryStore($request);

        $response = [
            'success' => true,
            'message' => trans('api.Category added successfully'),
        ];
        return response()->json($response);
    }
    public function changeCategoryStatus(Request $request): object
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
            'status' => 'nullable|boolean',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->courseRepository->changeCategoryStatus($request);

        $response = [
            'success' => true,
            'message' => trans('api.Category status changed successfully'),
        ];
        return response()->json($response);
    }
    public function courseCategoryDelete(Request $request): object
    {
        $rules = [
            'category_id' => 'required|exists:categories,id',
        ];
        $request->validate($rules, validationMessage($rules));

        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ], 403);
        }

        $this->courseRepository->courseCategoryDelete($request);

        $response = [
            'success' => true,
            'message' => trans('api.Category deleted successfully'),
        ];

        return response()->json($response);
    }

    public function storeCourseLevel(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ], 403);
        }

        $rules = [
            'title.*' => 'required|max:255',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->courseRepository->storeCourseLevel($request);

        $response = [
            'success' => true,
            'message' => trans('api.Course level added successfully'),
        ];
        return response()->json($response);
    }
    public function updateCourseLevel(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ], 403);
        }

        $rules = [
            'level_id' => 'required|exists:course_levels,id',
            'title.*' => 'required|max:255',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->courseRepository->updateCourseLevel($request);

        $response = [
            'success' => true,
            'message' => trans('api.Course level updated successfully'),
        ];
        return response()->json($response);
    }
    public function changeCourseLevelStatus(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ], 403);
        }

        $rules = [
            'level_id' => 'required|exists:course_levels,id',
            'status' => 'nullable|boolean',
        ];
        $request->validate($rules, validationMessage($rules));

        $this->courseRepository->changeCourseLevelStatus($request);

        $response = [
            'success' => true,
            'message' => trans('api.Course level status changed successfully'),
        ];

        return response()->json($response);
    }
    public function deleteCourseLevel(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ], 403);
        }

        $rules = [
            'level_id' => 'required|exists:course_levels,id',
        ];
        $request->validate($rules, validationMessage($rules));

        return $this->courseRepository->deleteCourseLevel($request);
    }
    public function courseDelete(Request $request): object
    {
        $rules = [
            'course_id' => 'required|exists:courses,id'
        ];
        $request->validate($rules, validationMessage($rules));

        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $id = $request->course_id;
        $hasCourse = CourseEnrolled::where('course_id', $id)->count();
        if ($hasCourse > 0) {
            return response()->json([
                'message' => 'Course Already Enrolled By ' . $hasCourse . ' Student'
            ]);
        } else {
            $this->courseRepository->courseDelete($request);

            return response()->json([
                'success' => true,
                'message' => trans('api.Course deleted successfully'),
            ]);
        }
    }
    public function categoryUpdate(Request $request): object
    {
        if (demoCheck()) {
            return response()->json([
                'message' => trans('api.For the demo version, you cannot change this')
            ],403);
        }

        $rules = [
            'category_id' => 'required|exists:categories,id',
            'name.*' => 'required|max:255',
        ];
        $request->validate($rules, validationMessage($rules));

        $request->merge([
            'id' => $request->category_id,
            'parent' => $request->parent_id,
            'image' => $request->icon,
        ]);

        $is_exist = Category::where('name', $request->name)->where('id', '!=', $request->id)->first();
        if ($is_exist) {
            return response()->json([
                'message' => 'This name has been already taken'
            ]);
        }

        $this->courseRepository->categoryUpdate($request);

        $response = [
            'success' => true,
            'message' => trans('api.Category updated successfully'),
        ];
        return response()->json($response);
    }
}
