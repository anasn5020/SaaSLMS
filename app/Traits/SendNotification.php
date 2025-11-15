<?php

namespace App\Traits;

trait SendNotification
{

    public function sendNotification($template, $user, $shortcodes, $action = [])
    {
        \App\Jobs\SendNotification::dispatch($template, $user, $shortcodes, $action);
    }
}
