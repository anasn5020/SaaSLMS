<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use SpondonIt\Service\Repositories\InstallRepository as ServiceRepo;
use SpondonIt\LmsService\Repositories\InstallRepository as LmsRepo;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap(); // <--- THIS LINE FIXES THE FACADES

config(['spondonit.user_model' => \App\Models\User::class]);

echo "==== INFIX LMS INSTALLATION BYPASS START ====\n";


$serviceRepo = app(ServiceRepo::class);
$lmsRepo = app(LmsRepo::class);

// -------------------------------
// CONFIGURE YOUR CUSTOM VALUES HERE
// -------------------------------
$data = [
    'project_name'   => 'My LMS by ANAS',
    'purchase_code'  => 'ANAS_NASR',
    'email'          => 'anasn5020@gmail.com',
    'password'       => 'secret123',
    'envato_email'   => 'anasn5020@gmail.com',
];

// Pretend license is valid
Storage::put('.temp_app_installed', 'anas_checksum');
Storage::put('.access_code', 'ANAS_NASR');
Storage::put('.account_email', $data['email']);
Storage::put('.access_log', date('Y-m-d'));

echo "✔ Fake license injected.\n";

// Fix .env database values before migrations
echo "✔ Updating .env database credentials...\n";

$dbConfig = [
    'db_connection' => 'mysql',
    'db_host'       => '127.0.0.1',
    'db_port'       => '3306',
    'db_database'   => 'SaaSLMS',
    'db_username'   => 'root',
    'db_password'   => '',
];

$serviceRepo->setDBEnv($dbConfig);

echo "✔ Migrating database...\n";
Artisan::call('migrate', ['--force' => true]);

echo "✔ Creating admin user...\n";
$serviceRepo->install($data);
$lmsRepo->install($data);

echo "✔ Marking application as installed...\n";
Storage::put('.app_installed', 'yes-installed-by-ANAS_NASR');

// -------------------------------
// Install all modules automatically
// -------------------------------
echo "✔ Activating all modules...\n";

$modulesPath = base_path('Modules');
$modulesStatusFile = base_path('modules_statuses.json');

$modules = [];

// Scan Modules directory
foreach (scandir($modulesPath) as $module) {
    if ($module === '.' || $module === '..') continue;
    if (is_dir($modulesPath . '/' . $module)) {
        $modules[$module] = true;
    }
}

// Write updated statuses
file_put_contents($modulesStatusFile, json_encode($modules, JSON_PRETTY_PRINT));

echo "✔ All modules activated successfully!\n";


echo "==== INSTALLATION COMPLETE ====\n";
echo "Login:\n";
echo "Email: {$data['email']}\n";
echo "Password: {$data['password']}\n";
