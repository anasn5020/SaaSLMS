<?php
namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Appointment\Entities\Schedule;
use Modules\Appointment\Entities\BillingDetailSchedule;

class ScheduleBookCheckoutPage extends Component
{
    public $request;
    public $slot_id;
    public function __construct($request, $slot)
    {
        $this->request = $request;
        $this->slot_id = $slot;
    }
    public function render()
    {
        $data = [];
        $data['type'] = $this->request->type;
        
        if (!empty($data['type'])) {
            $data['current'] = BillingDetailSchedule::where('user_id', Auth::id())->latest()->first();
        } else {
            $data['current'] = '';
        }

        $data['schedule'] = Schedule::with('userInfo', 'slotInfo')
                ->where('id', $this->slot_id)->first();
        $data['profile'] = Auth::user();
        $data['instructor'] = $data['schedule']->userInfo;
        $data['slotInfo'] = $data['schedule']->slotInfo;

        $data['profile']->cityName = $data['profile']->cityName();

        $data['bills'] = BillingDetailSchedule::with('country')->where('user_id', Auth::id())->latest()->get();

        $data['countries'] = DB::table('countries')->select('id', 'name')->get();
        $data['states'] = DB::table('states')->where('country_id', $data['profile']->country)
        ->where('id', $data['profile']->state)->select('id', 'name')->get();
        $data['cities'] = DB::table('spn_cities')->where('state_id', $data['profile']->state)
        ->where('id', $data['profile']->city)->select('id', 'name')->get();
        $countries = $data['countries'];
        return view(theme('components.schedule-book-checkout-page', $data));
    }
}
