<?php

namespace App\View\Components;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Appointment\Entities\AppointmentSettings;
use Modules\Appointment\Entities\Booking;
use Modules\Appointment\Entities\InstructorReview;
use Modules\Appointment\Http\Controllers\FrontendAppointmentController;
use Modules\Appointment\Repositories\Interfaces\BookingRepositoryInterface;
use Modules\Appointment\Repositories\Interfaces\MyAppointmentRepositoryInterface;
use Modules\Appointment\Repositories\Interfaces\ScheduleRepositoryInterface;
use Modules\Setting\Model\TimeZone;

class AppointmentSingleInstructor extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    protected $slug;
    protected $scheduleRepository;

    public function __construct($slug, ScheduleRepositoryInterface $scheduleRepository)
    {
        $this->slug = $slug;
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $slug = $this->slug;
        $user_id = auth()->check() ? auth()->user()->id : null;
        $data = $this->scheduleRepository->datePeriods();
        $data['timeZones'] = TimeZone::get();
        $data['instructor'] = User::with('teachingLanguages')
            ->withCount('instructorReviews')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug)->orWhere('id', $slug);
            })->first();
        $instructorReviews = $data['instructor']->instructorReviews;
        $totalReview = $data['instructor']->instructor_reviews_count;
        $data['courses'] = $data['instructor']->courses;

        $data['isBooked'] = auth()->check() ? Booking::where('instructor_id', $data['instructor']->id)
            ->where('user_id', $user_id)->first() : null;
        $data['hasOneReview'] = auth()->check() ? InstructorReview::where('instructor_id', $data['instructor']->id)
            ->where('user_id', $user_id)->first() : null;
        $data['count_5'] = FrontendAppointmentController::reviewCount($instructorReviews, 5.00, $totalReview);
        $data['count_4'] = FrontendAppointmentController::reviewCount($instructorReviews, 4.00, $totalReview);
        $data['count_3'] = FrontendAppointmentController::reviewCount($instructorReviews, 3.00, $totalReview);
        $data['count_2'] = FrontendAppointmentController::reviewCount($instructorReviews, 2.00, $totalReview);
        $data['count_1'] = FrontendAppointmentController::reviewCount($instructorReviews, 1.00, $totalReview);
        // return $data;
        $data['settings'] = AppointmentSettings::first();
        $data['wishlist_instructors'] = [];
        $data['trial_booked_instructors'] = [];
        if (Auth::check()) {
            $myAppointmentRepository = app()->make(MyAppointmentRepositoryInterface::class);
            $data['wishlist_instructors'] = $myAppointmentRepository->wishlist()['lists'] ?? [];

            $bookingRepository = app()->make(BookingRepositoryInterface::class);
            $data['trial_booked_instructors'] = $bookingRepository->getListByUser(Auth::id());
        }
        return view(theme('components.appointment-single-instructor'), $data);
    }
}
