<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Modules\Forum\Entities\Forum;

class DeleteOldestForum extends Command
{
    protected $signature = 'forum:oldest-delete';


    protected $description = 'Delete Oldest Forum Topic/Thread';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (isModuleActive('Forum')) {
            $date = Carbon::now()->subDays(30);
            Forum::whereNotNull('deleted_at')->where('created_at', '>=', $date)->delete();
        }
        return Command::SUCCESS;
    }
}
