<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\ZoomPro\Services\ZoomProService;


class GetZoomMeetingRecord extends Command
{
    protected $name = 'get-zoom-meeting-record';

    protected $description = 'Get Meeting Record';

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        if (isModuleActive('ZoomPro')){
            (new ZoomProService())->getMeetingRecords();
        }
    }

}
