<?php

namespace App\View\Components;

use App\Country;
use App\Models\Language;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Appointment\Entities\AppointmentSettings;
use Modules\Appointment\Entities\InstructorTeachingCategory;
use Modules\Appointment\Entities\InstructorTeachingLanguage;
use Modules\Appointment\Entities\Schedule;
use Modules\Appointment\Repositories\Interfaces\BookingRepositoryInterface;
use Modules\Appointment\Repositories\Interfaces\MyAppointmentRepositoryInterface;
use Modules\CourseSetting\Entities\Category;
use Modules\CourseSetting\Entities\CourseLevel;

class AppointmentInstructorPageSection extends Component
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function render()
    {
        $category = $this->request['category'] ?? null;
        $search = $this->request['search'] ?? null;
        $level = $this->request['level'] ?? null;
        $day = $this->request['days'] ?? null;
        $price = $this->request['price_range'] ?? null;
        $age = $this->request['age_range'] ?? null;
        $country = $this->request['country'] ?? null;
        $gender = $this->request['gender'] ?? null;
        $data['request'] = $this->request;

        $categories_ids = $category ? explode(',', $category) : [];
        $level_ids = $level ? explode(',', $level) : [];
        $days = $day ? explode(',', $day) : [];
        $gender_ids = $day ? explode(',', $gender) : [];
        $price_range = $price ? explode(';', $price) : null;
        $age_range = $age ? explode(';', $age) : null;
        $type = $this->request['type'] ?? null;

        $instructor_ids = [];
        if ($day) {
            $instructor_ids = Schedule::whereIn('day', $days)->pluck('user_id')->toArray();
        }
        $userIds = [];
        if ($search) {
            $searchCategoryIds = Category::where('name', 'LIKE', '%' . $search . '%')->get()->pluck('id')->toArray();
            $categoryUserIds = InstructorTeachingCategory::whereIn('category_id', $searchCategoryIds)->get()
                ->pluck('instructor_id')->toArray();
            $searchLanguageIds = Language::where('name', 'LIKE', '%' . $search . '%')->get()
                ->pluck('id')->toArray();
            $langUserIds = InstructorTeachingLanguage::whereIn('language_id', $searchLanguageIds)->get()
                ->pluck('instructor_id')->toArray();
            $userIds = array_merge($categoryUserIds, $langUserIds);
        }

        $data['instructors'] = User::with('userCountry:id,iso2', 'teachingLanguages', 'teachingCategories')
            ->withCount('instructorReviews')->where('status', 1)
            ->where('role_id', 2)
            ->whereHas('teachingCategories', function ($query) use ($categories_ids, $level_ids) {
                $query->when($categories_ids, function ($subQuery) use ($categories_ids) {
                    $subQuery->whereIn('category_id', $categories_ids);
                });
                $query->when($level_ids, function ($subQuery) use ($level_ids) {
                    $subQuery->where('level_id', $level_ids);
                });
            })
            ->when($gender_ids, function ($query) use ($gender_ids) {
                $query->whereIn('gender', $gender_ids);
            })
            ->when($price_range, function ($query) use ($price_range) {
                $query->whereBetween('hour_rate', $price_range);
            })
            ->when($age_range, function ($query) use ($age_range) {
                $query->whereBetween('age', $age_range);
            })
            ->when($country, function ($query) use ($country) {
                $query->where('country', $country);
            })
//            ->when($days, function ($query) use ($days) {
//                 dd();
//            })
            ->when($day, function ($query) use ($instructor_ids) {
                $query->whereIn('id', $instructor_ids);
            })
            ->when($search, function ($query) use ($search, $userIds) {
                $query->where('name', 'LIKE', '%' . $search . '%')->whereIn('id', $userIds);

            })->get();
        $data['categories'] = Category::with('activeSubcategories')
            ->withCount('activeSubcategories')
            ->where('status', 1)
            ->get();

        $data['levels'] = CourseLevel::where('status', 1)->get(['id', 'title']);
        $data['countries'] = Country::get(['id', 'name']);
        $data['weekDays'] = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $data['genders'] = ['Male', 'Female', 'Others'];
        $data['settings'] = AppointmentSettings::first();
        $data['priceRange'] = $price_range;
        $data['ageRange'] = $age_range;
        $data['categoriesIds'] = $categories_ids;
        $data['levelIds'] = $level_ids;
        $data['days'] = $days;
        $data['country'] = $country;
        $data['genderIds'] = $gender_ids;
        $data['type'] = $type;
        $data['wishlist_instructors'] = [];
        $data['trial_booked_instructors'] = [];
        if (Auth::check()) {
            $myAppointmentRepository = app()->make(MyAppointmentRepositoryInterface::class);
            $data['wishlist_instructors'] = $myAppointmentRepository->wishlist()['lists'] ?? [];

            $bookingRepository = app()->make(BookingRepositoryInterface::class);
            $data['trial_booked_instructors'] = $bookingRepository->getListByUser(Auth::id());
        }
        return view(theme('components.appointment-instructor-page-section'), $data);
    }
}
