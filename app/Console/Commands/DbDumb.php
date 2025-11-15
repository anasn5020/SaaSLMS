<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class DbDumb extends Command
{
    protected $signature = 'dump:sql_file';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $filename = "backup-" . Carbon::now()->format('Y-m-d_H-i-s') . ".sql";

        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/" . $filename;

        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar); $filename = "backup-" . \Carbon\Carbon::now()->format('Y-m-d_H-i-s') . ".sql";

        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/" . $filename;

        $returnVar = NULL;
        $output  = NULL;
        exec($command, $output, $returnVar);
        return 0;
    }
}
