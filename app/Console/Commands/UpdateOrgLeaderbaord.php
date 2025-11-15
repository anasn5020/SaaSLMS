<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Modules\Org\Entities\OrgLeaderboard;
use Modules\Org\Jobs\LeaderboardUpdateJob;

class UpdateOrgLeaderbaord extends Command
{

    protected $signature = 'org:update-leaderboard';

    protected $description = 'update leaderboard';

    public function handle()
    {
        $boardQuery = OrgLeaderboard::with(['branches', 'positions', 'users', 'assigns']);
        //condition
        $boards = $boardQuery->where('status', 1)->get();
        if (isModuleActive('Org')) {
            $query = User::where('status', 1);
            if (isModuleActive('UserType')) {
                $query->whereHas('userRoles', function ($q) {
                    $q->whereIn('role_id', [3]);
                });
            } else {
                $query->whereIn('role_id', [3]);
            }

            $query->with('branch');
            $students = $query->get();
            foreach ($students as $student) {
                LeaderboardUpdateJob::dispatch($student, $boards);
            }
        }
    }
}
