<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\CourseSetting\Entities\Course;
use Modules\Org\Entities\OrgBranch;
use Modules\Org\Entities\OrgPosition;
use Modules\Survey\Entities\Survey;
use Modules\Survey\Http\Controllers\SurveyController;

class SurveyNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $survey_id;

    public function __construct($survey_id)
    {
        $this->survey_id = $survey_id;
    }

    public function handle()
    {
        if (isModuleActive('Survey')) {
            $surveyController = new SurveyController();
            $survey = Survey::find($this->survey_id);
            if ($survey) {
                if ($survey->survey_type == 1) {
                    $course_info = Course::find($survey->course_id);
                    $users = $course_info->enrollUsers;
                } else {
                    if (isModuleActive('Org')) {

                        if ($survey->audience == 1 || $survey->position_audience == 1) {
                            $users = User::select('name', 'email', 'id', 'role_id', 'device_token')->where('role_id', 3)
                                ->where('status', 1)
                                ->get();
                        } else {
                            $branch_ids = $survey->branches->pluck('branch_id')->toArray();
                            $branches = OrgBranch::whereIn('id', $branch_ids)->pluck('code')->toArray();


                            $position_ids = $survey->positions->pluck('position_id')->toArray();
                            $positions = OrgPosition::whereIn('id', $position_ids)->pluck('code')->toArray();

                            $query = User::whereIn('org_chart_code', $branches)->orWhereIn('org_position_code', $positions);


                            $users = $query->select('name', 'email', 'id', 'role_id', 'device_token')->where('role_id', 3)
                                ->where('status', 1)->get();
                        }
                    } else {
                        $users = User::select('name', 'email', 'id', 'role_id', 'device_token')->where('role_id', 3)
                            ->where('status', 1)
                            ->get();
                    }


                }

                foreach ($users as $user) {
                    $surveyController->assignSurvey($survey, $user);
                }
            }
        }
    }
}
