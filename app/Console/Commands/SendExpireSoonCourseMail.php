<?php

namespace App\Console\Commands;

use App\Jobs\ExpireSoonNotificaiton;
use Illuminate\Console\Command;
use Modules\CourseSetting\Entities\CourseEnrolled;

class SendExpireSoonCourseMail extends Command
{
    protected $signature = 'app:send-mail-expire-soon-course';


    protected $description = 'Send mail before expire course';


    public function handle()
    {
        $enrolls = CourseEnrolled::query()
            ->whereHas('course', function ($q) {
                $q->where('access_limit', '>', 0);
                $q->where('status', 1);
            })->where('send_expire_notification', 0)
            ->with('user', 'course')->get();

        ExpireSoonNotificaiton::dispatch($enrolls);
    }
}
