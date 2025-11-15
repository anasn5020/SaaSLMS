<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Spatie\DbDumper\Databases\MySql;

class BackupDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        try {
            $today = date("d-m-Y-m-His".rand(1,999));

            $dir = public_path("database-backup/".$today);

            if(is_dir($dir))
            {
                rmdir($dir);
            }
            mkdir($dir,0777, true);

            if (!empty(env('DB_DATABASE')) && !empty(env('DB_USERNAME')) && !empty(env('DB_PASSWORD'))) {
                MySql::create()
                    ->setDbName(env('DB_DATABASE'))
                    ->setUserName(env('DB_USERNAME'))
                    ->setPassword(env('DB_PASSWORD'))
                    ->dumpToFile($dir."/{$today}-dump.sql");
            }


        }catch (Exception $exception)
        {
            Log::error($exception->getMessage());
        }
    }
}
