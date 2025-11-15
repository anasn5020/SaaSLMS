<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendGeneralEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $user, $type, $shortcodes;

    public function __construct($user, $type, $shortcodes)
    {
        $this->user = $user;
        $this->type = $type;
        $this->shortcodes = $shortcodes;
    }

    public function handle()
    {
        Log::info($this->type . '->send mail');
        send_email($this->user, $this->type, $this->shortcodes);
    }
}
