<?php

namespace App\Http\Controllers\Api\V2\CustomMeeting;

use App\Repositories\Interfaces\CustomMeetingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\VirtualClass\Entities\CustomMeeting;

class CustomMeetingController extends Controller
{
    public function __construct(private CustomMeetingRepositoryInterface $customMeetingRepository)
    {
    }

    public function update(Request $request)
    {
        $rules = [
            'meeting_id' => 'required',
            'topic' => 'required',
            'duration' => 'required',
            'host' => 'required',
            'date' => 'required',
            'time' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        if($this->customMeetingRepository->update($request)){
            return response()->json([
                'success' => true,
                'message'=> trans('api.Schedule updated successfully')
            ]);
        }
    }
}
