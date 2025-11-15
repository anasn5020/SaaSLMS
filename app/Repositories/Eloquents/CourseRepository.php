<?php

namespace App\Repositories\Eloquents;

use App\Http\Resources\api\v2\Category\CategoryDetailResource;
use App\Http\Resources\api\v2\Category\CategoryListResource;
use App\Http\Resources\api\v2\Course\CourseDetailResource;
use App\Http\Resources\api\v2\Course\CourseListResource;
use App\Http\Resources\api\v2\Course\LevelListResource;
use App\LessonComplete;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Traits\Filepond;
use App\Traits\ImageStore;
use App\Traits\SendNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\BundleSubscription\Entities\BundleCourse;
use Modules\Certificate\Entities\Certificate;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseLevel;
use Modules\CourseSetting\Entities\Lesson;
use Modules\CourseSetting\Http\Controllers\LessonController;
use Modules\CourseSetting\Http\Controllers\VimeoController;
use Modules\Forum\Services\ForumService;
use Modules\Membership\Repositories\Interfaces\MembershipCourseRepositoryInterface;
use Modules\Payment\Entities\Cart;
use Modules\Setting\Repositories\MediaManagerRepository;
use Throwable;

class CourseRepository implements CourseRepositoryInterface
{
    use ImageStore, Filepond,SendNotification;
    private $mediaManagerRepository;
    public function __construct(MediaManagerRepository $mediaManagerRepository)
    {
        $this->mediaManagerRepository = $mediaManagerRepository;
    }
    public function courses(object $request): object
    {
        switch ($request->status) {
            case 'active':
                $status = 'active';
                break;
            case 'inactive':
                $status = 'inactive';
                break;
            default:
                $status = null;
                break;
        }
        $courses = Course::latest('id')
            ->when($type = $request->type, function ($courses) use ($type) {
                $courses->where('type', $type);
            }, function ($courses) {
                $courses->whereIn('type', [1, 2]);
            })
            ->when($search = $request->search, function ($course) use ($search) {
                $course->whereLike('title', $search);
            })
            ->when($category = $request->category_id, function ($course) use ($category) {
                $course->where('category_id', $category);
            })
            ->when($user = $request->instructor_id, function ($course) use ($user) {
                $course->where('user_id', $user);
            })
            ->when($status, function ($course) use ($status) {
                $course->where('status', $status == 'active' ? 1 : 0);
            });

        if (auth()->user()->role_id != 1) {
            $courses->where(function ($q) {
                $q->where('user_id', auth()->id())
                    ->orWhere('assistant_instructors', auth()->id());
            });
        }

        return CourseListResource::collection($courses->paginate($request->get('per_page', 15)));
    }

    public function changeStatus(object $request): bool
    {
        $user = auth()->user();
        if ($user->role_id == 1 || $user->role_id == 2) {
            $course = Course::when($user->role_id == 2, function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->find($request->id);

            $course->update([
                'status' => (bool)$request->status
            ]);
            return true;
        } else {
            return false;
        }
    }

    public function courseDetail(object $request): object
    {
        $course = Course::whereIn('type', [1, 2])->find($request->course_id);

        return new CourseDetailResource($course);
    }

    public function courseUpdate(object $request): bool
    {
        $request->merge([
            'quiz' => $request->quiz_id,
            'publish_date' => Carbon::createFromFormat('m-d-Y', $request->publish_date)->format('Y-m-d')
        ]);

        session()->flash('type', 'update');
        session()->flash('id', $request->id);
        session()->flash('type', 'courseDetails');

        $course = Course::find($request->id);
        $course->scope = (int)$request->scope;
        $course->access_limit = (int)$request->access_limit;

        if (!empty($request->assign_instructor)) {
            $course->user_id = $request->assign_instructor;
        }
        $course->drip = (int)$request->get('drip', 0);
        $course->complete_order = (int)$request->complete_order;
        $course->lang_id = $request->language;

        /* if (isModuleActive('Org')) {
            $course->setTranslation('title', 'en', $request->title[$code]);
            $course->setTranslation('title', 'vi', $request->title[$code]);
        } else {
        } */
        foreach ($request->title as $key => $title) {
            $course->setTranslation('title', $key, $title);
        }

        foreach ($request->about as $key => $about) {
            $course->setTranslation('about', $key, $about);
        }

        foreach ($request->requirements as $key => $requirements) {
            $course->setTranslation('requirements', $key, $requirements);
        }

        foreach ($request->outcomes as $key => $outcomes) {
            $course->setTranslation('outcomes', $key, $outcomes);
        }
        $course->duration = $request->duration;
        $course->subscription_list = $request->subscription_list;

        if (isModuleActive('UpcomingCourse')) {
            $course->is_upcoming_course = (int)$request->is_upcoming_course;
            $course->publish_date = $request->publish_date && $request->is_upcoming_course ? date('Y-m-d', strtotime($request->publish_date)) : null;
            $course->booking_amount = $request->is_upcoming_course && $request->booking_amount ? (int)$request->booking_amount : null;
            $course->is_allow_prebooking = $request->is_upcoming_course && $request->is_allow_prebooking ? (int)$request->is_allow_prebooking : null;
        }

        if (showEcommerce()) {
            if ($request->is_discount == 1) {
                $course->discount_price = $request->discount_price;
            } else {
                $course->discount_price = null;
            }
            if ($request->is_free == 0) {
                $course->price = (int)$request->price;
                $course->discount_price = null;
            } else {
                $course->price = 0;
            }
        } else {
            $course->price = 0;
            $course->discount_price = null;
        }

        $course->level = $request->level;
        $course->school_subject_id = $request->get('school_subject_id', 0);

        if ($request->iap) {
            $course->iap_product_id = $request->iap_product_id;
        } else {
            $course->iap_product_id = null;
        }
        $course->mode_of_delivery = $request->mode_of_delivery;

        $course->show_overview_media = $request->show_overview_media ? 1 : 0;

        if (isModuleActive('Org')) {
            $course->required_type = (int)$request->required_type;
        } else {
            $course->required_type = 0;
        }
        $course->host = $request->host;
        $course->meta_keywords = $request->meta_keywords;
        $course->meta_description = $request->meta_description;
        $course->type = $request->type;
        if ($request->type == 1) {
            $course->quiz_id = null;
            $course->category_id = $request->category;
            $course->subcategory_id = $request->sub_category;
        } elseif ($request->type == 2) {
            $course->quiz_id = $request->quiz;
            $course->category_id = null;
            $course->subcategory_id = null;
        }

        if (Settings('frontend_active_theme') == "edume") {
            $course->what_learn1 = $request->what_learn1;
            $course->what_learn2 = $request->what_learn2;
        }
        if (!empty($request->assistant_instructors)) {
            $assistants = $request->assistant_instructors;
            if (($key = array_search($course->user_id, $assistants)) !== false) {
                unset($assistants[$key]);
            }
            if (!empty($assistants)) {
                $course->assistant_instructors = json_encode(array_values($assistants));
            } else {
                $course->assistant_instructors = null;
            }
        }
        if (isModuleActive('Org')) {
            $course->org_leaderboard_point = (int)$request->get('org_leaderboard_point', 0);
        }

        if (isModuleActive('SupportTicket') && Schema::hasColumn('courses', 'support')) {
            // if (isset($request->support)) {
            //     $course->support = true;
            // } else {
            //     $course->support = false;
            // }
            $course->support = (int)$request->support;
        }

        $course->image = null;
        $course->thumbnail = null;
        $course->trailer_link = null;
        $course->save();

        if ($request->get('host') == "Vimeo") {
            if (config('vimeo.connections.main.upload_type') == "Direct") {
                $vimeoController = new VimeoController();
                $course->trailer_link = $vimeoController->uploadFileIntoVimeo(md5(time()), $request->vimeo);
            } else {
                $course->trailer_link = $request->vimeo;
            }
        } elseif ($request->get('host') == "VdoCipher") {
            $course->trailer_link = $request->vdocipher;
        } elseif ($request->get('host') == "Youtube") {
            $course->trailer_link = $request->trailer_link;
        } elseif ($request->get('host') == "Self") {
            if ($request->get('file')) {
                $course->trailer_link = $this->getPublicPathFromServerId($request->get('file'), 'local');
            }
        } else {
            $course->trailer_link = null;
        }

        if ($request->image) {
            $imageUrl = $this->saveImage($request->image);
            $course->image = $imageUrl;
            $course->thumbnail = $imageUrl;
        }

        if ($request->file) {
            $course->trailer_link = $this->saveImage($request->file);
        }
        $course->save();

        $this->updateTotalCountForCourse($course);

        if ($course->type == 2) {
            $category = $course->quiz->category;
        } else {
            $category = $course->category;
        }
        $this->updateTotalCountForCategory($category);

        return true;
    }

    private function updateTotalCountForCourse($course)
    {
        $course->total_chapters = count($course->chapters);
        $course->total_lessons = count($course->lessons);
        $course->total_quiz_lessons = count($course->lessonQuizzes);
        $course->total_comments = count($course->comments);
        $course->total_reviews = count($course->reviews);
        $course->save();
    }

    private function updateTotalCountForCategory($category)
    {
        $category->total_courses = count($category->courses);
        $category->total_quizzes = $category->QuizzesCoun;
        $category->save();
    }

    public function categories(object $request): object
    {
        $categories = Category::when($search = $request->search, function ($category) use ($search) {
            $category->whereLike('name', $search);
        })
            ->orderBy('position_order')
            ->paginate($request->per_page ?? 10);
        return CategoryListResource::collection($categories);
    }

    public function categoryDetail(object $request): object
    {
        $category = Category::find($request->category_id);
        return new CategoryDetailResource($category);
    }

    public function subcategories($request): object
    {
        $subcategories = Category::where('status', 1)
            ->where('parent_id', $request->category_id)
            ->orderBy('position_order', 'ASC')
            ->get();
        return CategoryListResource::collection($subcategories);
    }

    public function levels(object $request): object
    {
        $data = CourseLevel::when($search = $request->search, function ($level) use ($search) {
            $level->whereLike('title', $search);
        })
            ->paginate($request->per_page ?? 10);

        return LevelListResource::collection($data);
    }

    public function storeCourse(object $request): bool
    {
        $request->merge([
            'quiz' => $request->quiz_id,
        ]);

        session()->flash('type', 'store');

        $course = new Course;
        if (isModuleActive('Membership')) {
            if ($request->filled('is_membership')) {
                $course->is_membership = 1;
            }
            if ($request->filled('all_level_member')) {
                $course->all_level_member = $request->all_level_member;
            }
        }

        $course->user_id = auth()->id();
        if ($request->type == 1) {
            $course->quiz_id = null;
            $course->category_id = (int)$request->category;
            $course->subcategory_id = (int)$request->sub_category;
        } elseif ($request->type == 2) {
            $course->quiz_id = (int)$request->quiz;
            $course->category_id = null;
            $course->subcategory_id = null;
        }


        $course->lang_id = (int)$request->language;
        $course->scope = (int)$request->scope;
        $course->access_limit = (int)$request->access_limit;

        /* if (isModuleActive('Org')) {
            $course->setTranslation('title', 'en', $request->title[$code]);
            $course->setTranslation('title', 'vi', $request->title[$code]);
        } else {
        } */

        foreach ($request->title as $key => $title) {
            $course->setTranslation('title', $key, $title);
        }

        //for support ticket
        if (isModuleActive('SupportTicket') && Schema::hasColumn('courses', 'support')) {
            // if (isset($request->support)) {
            //     $course->support = true;
            // } else {
            // }
            $course->support = (int)$request->support;
        }

        if (isModuleActive('UpcomingCourse') && $request->is_upcoming_course == true) {
            $request->merge([
                'publish_date' => Carbon::createFromFormat('m-d-Y', $request->publish_date)->format('Y-m-d'),
            ]);
            $course->is_upcoming_course = true;
            $course->publish_date = date('Y-m-d', strtotime($request->publish_date));
            $course->publish_status = 'pending';
            $course->booking_amount = (int)$request->booking_amount;
            $course->is_allow_prebooking = (bool)$request->is_allow_prebooking;
        }

        foreach ($request->about as $key => $about) {
            $course->setTranslation('about', $key, $about);
        }

        foreach ($request->requirements as $key => $requirements) {
            $course->setTranslation('requirements', $key, $requirements);
        }

        foreach ($request->outcomes as $key => $outcomes) {
            $course->setTranslation('outcomes', $key, $outcomes);
        }

        $course->slug = null;
        $course->duration = $request->duration;

        if (showEcommerce()) {
            if ($request->is_discount == 1) {
                $course->discount_price = (int)$request->discount_price;
            } else {
                $course->discount_price = null;
            }
            if ($request->is_free == 0) {
                $course->price = (int)$request->price;
                $course->discount_price = null;
            } else {
                $course->price = 0;
                $course->discount_price = null;
            }
        } else {
            $course->price = 0;
            $course->discount_price = null;
        }

        if (isModuleActive('Org')) {
            $course->required_type = (int)$request->required_type;
        } else {
            $course->required_type = 0;
        }

        $course->publish = 1;
        $course->status = 0;
        $course->level = $request->level;
        $course->school_subject_id = $request->get('school_subject_id', 0);
        if ($request->iap) {
            $course->iap_product_id = $request->iap_product_id;
        } else {
            $course->iap_product_id = null;
        }

        $course->mode_of_delivery = $request->mode_of_delivery;

        $course->show_overview_media = $request->show_overview_media ? 1 : 0;
        $course->host = $request->host;
        $course->subscription_list = $request->subscription_list;

        if (!empty($request->assign_instructor)) {
            $course->user_id = $request->assign_instructor;
        }
        $course->save();

        if ($request->get('host') == "Vimeo") {
            if (config('vimeo.connections.main.upload_type') == "Direct") {
                $vimeoController = new VimeoController();
                $course->trailer_link = $vimeoController->uploadFileIntoVimeo(md5(time()), $request->vimeo);
            } else {
                $course->trailer_link = $request->vimeo;
            }
        } elseif ($request->get('host') == "VdoCipher") {
            $course->trailer_link = $request->vdocipher;
        } elseif ($request->get('host') == "Youtube") {
            $course->trailer_link = $request->trailer_link;
        } elseif ($request->get('host') == "Self") {
            $course->trailer_link = $this->saveImage($request->file);
        } else {
            $course->trailer_link = null;
        }


        if (!empty($request->assign_instructor)) {
            $course->user_id = $request->assign_instructor;
        }


        if (!empty($request->assistant_instructors)) {
            $assistants = $request->assistant_instructors;
            if (($key = array_search($course->user_id, $assistants)) !== false) {
                unset($assistants[$key]);
            }
            if (!empty($assistants)) {
                $course->assistant_instructors = json_encode(array_values($assistants));
            }
        }

        $course->meta_keywords = $request->meta_keywords;
        $course->meta_description = $request->meta_description;

        $course->type = $request->type;
        $course->drip = (bool)$request->drip;
        $course->complete_order = (int)$request->complete_order;
        if (Settings('frontend_active_theme') == "edume") {
            $course->what_learn1 = $request->what_learn1;
            $course->what_learn2 = $request->what_learn2;
        }
        /* if (isModuleActive('Org')) {
            $course->org_leaderboard_point = (int)$request->get('org_leaderboard_point', 0);
        } */


        $course->save();

        if ($request->image) {
            $imageUrl = $this->saveImage($request->image);
            $course->image = $imageUrl;
            $course->thumbnail = $imageUrl;
            $course->save();
        }

        if ($course->type == 2) {
            $category = $course->quiz->category;
        } else {
            $category = $course->category;
        }
        $this->updateTotalCountForCourse($course);
        $this->updateTotalCountForCategory($category);
        checkGamification('each_course', 'courses');
        if (isModuleActive('Membership')) {
            $membershipInterface = App::make(MembershipCourseRepositoryInterface::class);
            $request->merge([
                'course_id' => $course->id,
            ]);
            $membershipInterface->storeCourseMember($request->all());
        }

        if (auth()->user()->role_id != 1) {
            $admins = User::where('role_id', 1)->get();
            foreach ($admins as $user) {
                $this->sendNotification('NewCourseCreated', $user, [
                    'admin' => $user->name,
                    'course' => $course->title,
                    'instructor' => $course->user->name,
                ],[
                    trans('common.View'),
                    courseDetailsUrl(@$course->id, @$course->type, @$course->slug),
                    'course',
                    $course->id
                ]);

            }
        }
        if (isModuleActive('Forum')) {
            $forumService = new ForumService();
            $forumService->autoTopic('topic', $course);
        }
        return true;
    }

    public function chapterRearrange(object $request): bool
    {
        if (in_array(auth()->user()->role_id, [1, 2])) {
            $chapters = Course::when(auth()->user()->role_id == 2, function ($q) {
                $q->where('user_id', auth()->user()->id);
            })->findOrFail($request->course_id)->chapters;
            if (!empty($request->chapter_id)) {
                foreach ($request->chapter_id as $key => $id) {
                    $chapter = $chapters->find($id);
                    if ($chapter) {
                        $chapter->position = ++$key;
                        $chapter->save();
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }

    public function certificateList(): object
    {
        if (auth()->user()->role_id == 1) {
            $data = Certificate::latest()->select('id', 'title as certificate_name')->get();
        } else {
            $data = Certificate::where('created_by', auth()->user()->id)->latest()->select('id', 'title as certificate_name')->get();
        }

        return $data;
    }

    public function assignCertificate(object $request): object
    {
        session()->flash('type', 'certificate');
        session()->flash('id', $request->course_id);
        $rules = [
            'course_id' => 'required|exists:courses,id',
            'certificate_id' => 'required|exists:certificates,id',
        ];
        $request->validate($rules, validationMessage($rules));


        $course = Course::find($request->course_id);

        if (isModuleActive('CertificatePro') && Settings('use_certificate_template') == 'pro') {
            $course->pro_certificate_id = $request->certificate_id;
        } else {
            $course->certificate_id = $request->certificate_id;
        }

        $course->save();

        $response = [
            'success'   => true,
            'message'   => trans('api.Assign certificate updated successfully'),
        ];

        return response()->json($response);
    }

    public function categoryStore(object $request): bool
    {
        $request->merge([
            'icon' => $request->image,
            'parent' => $request->parent_id,
        ]);

        try {
            DB::transaction(function () use ($request) {
                $check_position = Category::where('position_order', $request->position_order)->first();

                if ($check_position != '') {
                    $old_categories = Category::where('position_order', '>=', $request->position_order)->get();

                    foreach ($old_categories as $old_category) {
                        $old_category->position_order = $old_category->position_order + 1;
                        $old_category->save();
                    }
                }

                $store = new Category;

                foreach ($request->get('name', []) as $key => $name) {
                    $store->setTranslation('name', $key, $name);
                }
                foreach ($request->get('description', []) as $key => $description) {
                    $store->setTranslation('description', $key, $description);
                }
                $store->status = (bool)$request->status;
                if (!empty($request->parent)) {
                    $store->parent_id = $request->parent;
                } else {
                    $store->parent_id = null;
                }
                $store->position_order = $request->position_order;
                $store->color = $request->color;

                $store->user_id = auth()->id();
                $store->save();

                if ($request->image) {
                    $store->image = $this->saveImage($request->image);
                }
                if ($request->thumbnail) {
                    $store->thumbnail = $this->saveImage($request->thumbnail);
                }
                $store->save();

                if (isModuleActive('OrgInstructorPolicy')) {
                    if (!empty(auth()->user()->policy_id)) {
                        OrgPolicyCategory::create([
                            'category_id' => $store->id,
                            'policy_id' => auth()->user()->policy_id,
                            'status' => 1
                        ]);
                    }
                }
            });
            return true;
        } catch (Throwable $th) {
            return false;
        }
    }

    public function changeCategoryStatus(object $request): bool
    {
        $id = $request->category_id;
        $status = (bool)$request->status;

        $course = Category::find($id);
        $course->status = $status;
        $course->updated_at = now();
        $course->save();
        return true;
    }

    public function courseCategoryDelete(object $request): bool
    {
        Category::destroy($request->category_id);
        return true;
    }

    public function storeCourseLevel(object $request): bool
    {
        $level = new CourseLevel();
        $level->id = CourseLevel::max('id') + 1;
        foreach ($request->title as $key => $title) {
            $level->setTranslation('title', $key, $title);
        }
        $level->save();
        return true;
    }

    public function updateCourseLevel(object $request): bool
    {
        $edit = CourseLevel::find($request->level_id);
        foreach ($request->title as $key => $title) {
            $edit->setTranslation('title', $key, $title);
        }
        $edit->save();
        return true;
    }

    public function changeCourseLevelStatus(object $request): bool
    {
        CourseLevel::find($request->level_id)->update([
            'status' => (bool)$request->status
        ]);
        return true;
    }

    public function deleteCourseLevel(object $request): object
    {
        $hasCourse = Course::where('level', $request->level_id)->count();
        if ($hasCourse > 0) {
            return response()->json([
                'message' => trans("api.You can't delete this level because it has been used in a course")
            ], 422);
        } else {
            $level = CourseLevel::find($request->level_id);
            $level->delete();
            return response()->json([
                'success' => true,
                'message' => trans('api.Course level deleted successfully'),
            ]);
        }
    }

    public function courseDelete(object $request): bool
    {
        $id = $request->course_id;
        $carts = Cart::where('course_id', $id)->get();
        foreach ($carts as $cart) {
            $cart->delete();
        }

        $course = Course::findOrFail($id);
        if ($course->host == "Self") {
            if (file_exists($course->trailer_link)) {
                unlink($course->trailer_link);
            }
        }

        $chapters = Chapter::where('course_id', $course->id)->get();
        foreach ($chapters as $chapter) {
            $lessons = Lesson::where('chapter_id', $chapter->id)->where('course_id', $course->id)->get();
            foreach ($lessons as $key => $lesson) {
                $complete_lessons = LessonComplete::where('lesson_id', $lesson->id)->get();
                foreach ($complete_lessons as $complete) {
                    $complete->delete();
                }
                $lessonController = new LessonController();
                $lessonController->lessonFileDelete($lesson);
                $lesson->delete();
            }

            $chapter->delete();
        }

        if (isModuleActive('BundleSubscription')) {
            $bundle = BundleCourse::where('course_id', $course->id)->get();
            foreach ($bundle as $b) {
                $b->delete();
            }
        }
        if ($course->type == 2) {
            $category = $course->quiz->category;
        } else {
            $category = $course->category;
        }
        $course->delete();
        $this->updateTotalCountForCategory($category);
        return true;
    }

    public function categoryUpdate(object $request): bool
    {
        $check_position = Category::where('position_order', $request->position_order)->first();

        if ($check_position != '') {
            $old_categories = Category::where('position_order', '>=', $request->position_order)->get();

            foreach ($old_categories as $old_category) {
                $old_category->position_order = $old_category->position_order + 1;
                $old_category->save();
            }
        }

        $store = Category::find($request->id);
        foreach ($request->get('name', []) as $key => $name) {
            $store->setTranslation('name', $key, $name);
        }
        foreach ($request->get('description', []) as $key => $description) {
            $store->setTranslation('description', $key, $description);
        }
        $store->status = $request->status;
        $store->url = $request->url;
        $store->title = $request->title;
        $store->show_home = (int)$request->show_home;
        $store->position_order = $request->position_order;
        $store->color = $request->color;

        if (!empty($request->parent)) {
            $store->parent_id = $request->parent;
        } else {
            $store->parent_id = null;
        }
        $store->image = null;
        $store->thumbnail = null;
        $store->save();

        if ($request->image) {
            $store->image = $this->saveImage($request->image);
        }
        if ($request->thumbnail) {
            $store->thumbnail = $this->saveImage($request->thumbnail);
        }
        $store->save();
        return true;
    }
}
