<?php

namespace App\Console;

use App\Console\Commands\AppReset;
use App\Console\Commands\BackupDatabaseCommand;
use App\Console\Commands\BackupFileCommand;
use App\Console\Commands\GetZoomMeetingRecord;
use App\Console\Commands\InstructorPayout;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        BackupDatabaseCommand::class,
        BackupFileCommand::class,
        AppReset::class,
        GetZoomMeetingRecord::class

    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('backup:backup_file')->dailyAt('01:30');
        $schedule->command('backup:clean')->dailyAt('01:30');
        $schedule->command('backup:run --only-db')->dailyAt('01:35');


        if (isModuleActive('Gift')) {
            $schedule->command('send:gift')->everyTenMinutes();
        }
        if (isModuleActive('Installment')) {
            $schedule->command('installment:due-check')->dailyAt('03:35');
        }

        if (isModuleActive('Subscription')) {
            $schedule->command('check:subscription');
            $schedule->command('apply:commission');
        }

        if (isModuleActive('OrgSubscription')) {
            $schedule->command('alert:orgSubscription')->dailyAt('00:00');
//            $schedule->command('alert:orgSubscription')->dailyAt('00:00');
        }

        $schedule->command('app:send-mail-expire-soon-course')->dailyAt('00:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
