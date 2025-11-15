<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrgStudentSignupNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $new_student, $password;

    public function __construct($new_student, $password)
    {
        $this->new_student = $new_student;
        $this->password = $password;
    }


    public function handle()
    {
        Log::info('send mail');
        send_email($this->new_student, 'Offline_Enrolled', ['email' => $this->new_student->email, 'password' => $this->password]);
    }
}
