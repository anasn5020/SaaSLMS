<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\SendMail;
use Illuminate\Support\Facades\Artisan;

class BackupFileCommand extends Command
{
    use SendMail;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:backup_file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All File Backup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('backup:run --only-files',[
            '--no-interaction' => true,
        ]);
        return 1;
    }
}
