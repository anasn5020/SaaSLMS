<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Appointment\Entities\Booking;
use Modules\Appointment\Entities\Schedule;
use Modules\Appointment\Entities\TimeSlot;
use Modules\Appointment\Repositories\Interfaces\ScheduleRepositoryInterface;

class AppointmentMyAppointmentPageSection extends Component
{

    public $request;
    public $scheduleRepository;
    public function __construct(
        $request,
        ScheduleRepositoryInterface $scheduleRepository
    ) {
        $this->request = $request;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function render()
    {
        $next_date = $this->request->next_date ?? null;
        $end_date = $this->request->end_date ?? null;
        $user_id = auth()->user()->id;
        $booking_list = Booking::with('schedule')->where('user_id', $user_id)->groupBy('schedule_id');
       
        $data['booking_list'] = $booking_list->get();
        
        $data += $this->scheduleRepository->datePeriods($next_date, $end_date);
        
        return view(theme('components.appointment-my-appointment-page-section'), $data);
    }
}
