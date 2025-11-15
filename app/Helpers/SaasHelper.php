<?php

use App\Models\LmsInstitute;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\LmsSaas\Entities\SaasCheckout;
use Modules\LmsSaas\Entities\SaasInstitutePlanManagement;
use Modules\PaymentMethodSetting\Entities\PaymentMethodCredential;


if (!function_exists('AddLmsId')) {
    function AddLmsId()
    {

        Cache::rememberForever('getAllTables', function () {
            $ignoreTables = [
                'spatial_ref_sys',
            ];
            $driver = config('database.default');

            if ($driver === 'mysql') {
                $tables = DB::select('SHOW TABLES');
            } elseif ($driver === 'pgsql') {
                $tables = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
            }
            foreach ($tables as $key => $table_name) {
                $table_name = array_values(get_object_vars($table_name));
                $table_name = $table_name[0] ?? '';
                if (hasTable($table_name) && !in_array($table_name, $ignoreTables)) {
                    Schema::table($table_name, function (Blueprint $table) use ($table_name) {
                        if (!hasTableColumn($table_name, 'lms_id')) {
                            $table->integer('lms_id')->default(1);
                        }
                    });
                }

            }
            return true;
        });


    }
}
if (!function_exists('SaasDomain')) {
    function SaasDomain()
    {

        $domain = 'main';
        $saas_module = 'Modules/LmsSaas/Providers/LmsSaasServiceProvider.php';
        $saas_module2 = 'Modules/LmsSaasMD/Providers/LmsSaasMDServiceProvider.php';

        if (file_exists($saas_module) || file_exists($saas_module2)) {

            $module_status = json_decode(file_get_contents('modules_statuses.json'), true);
            if ((isset($module_status['LmsSaas']) && $module_status['LmsSaas']) || (isset($module_status['LmsSaasMD']) && $module_status['LmsSaasMD'])) {
                if (config('app.short_url') != request()->getHost()) {
                    $short_url = preg_replace('#^https?://#', '', rtrim(env('APP_URL', 'http://localhost'), '/'));
                    $domain = str_replace('.' . $short_url, '', request()->getHost());
                }
            }
        }
        if (isModuleActive('SaasBranch')) {
            $lmsParent = LmsInstitute::on(config('database.default'))->whereDomain($domain)->first();
            if (!empty($lmsParent->parent_id)) {
                $lms = LmsInstitute::on(config('database.default'))->find($lmsParent->parent_id);
                if ($lms) {
                    $domain = $lms->domain;
                }
            }
        }
        return $domain;
    }
}

if (!function_exists('SaasFullDomain')) {
    function SaasFullDomain()
    {
        return saasDomain() . '.' . config('app.short_url');
    }
}

if (!function_exists('UserDomainCheck')) {
    function UserDomainCheck()
    {
        if (Auth::check()) {
            $user_domain = LmsInstitute::find(Auth::user()->lms_id);
            if ($user_domain->domain != SaasDomain()) {
                return false;
            } else {
                return true;
            }
        }

    }
}
if (!function_exists('SaasInstitute')) {
    function SaasInstitute()
    {
        try {
            DB::connection()->getPdo();
            $hasInstituteTable = Cache::rememberForever('saasInstituteTable' . SaasDomain(), function () {
                return hasTable('lms_institutes');
            });
        } catch (\Exception $e) {
            $hasInstituteTable = false;
        }

        if ($hasInstituteTable) {
            try {
                return Cache::rememberForever('saasInstitute' . SaasDomain(), function () {
                    $lms = LmsInstitute::where('domain', SaasDomain())->first();
                    if (!empty($lms->parent_id)) {
                        $parentLms = LmsInstitute::find($lms->parent_id);
                        if ($parentLms) {
                            return $parentLms;
                        }
                    }
                    return $lms;
                });
            } catch (\Throwable $th) {
                return LmsInstitute::first();
            }
        } else {
            $institute = collect();
            $institute->name = 'InfixLMS';
            $institute->description = 'InfixLMS';
            $institute->domain = 'main';
            $institute->user_id = 1;
            $institute->status = 1;
            $institute->id = 1;
            return $institute;

        }


    }
}
// if (!function_exists('PaymentMethodCredential')) {
//     function PaymentMethodCredential()
//     {
//         try {
//             return app('getPaymentSetting');
//         } catch (\Throwable $th) {
//            return "false";
//         }
//     }
// }
if (!function_exists('getPaymentEnv')) {
    function getPaymentEnv($value)
    {
        try {

            $domain = SaasDomain();
            $path = base_path('storage/app/payment.json');
            if (file_exists($path)) {
                $data = json_decode(file_get_contents($path), true);
                $settings = new \stdClass;
                if (!empty($data)) {
                    foreach (array_keys($data) as $property) {
                        $settings->{$property} = $data[$property];
                    }
                }
                return $settings->$domain[$value] ?? '';
            } else {
                return '';
            }
        } catch (\Throwable $th) {
            return "false";
        }
    }
}
if (!function_exists('getMainPaymentEnv')) {
    function getMainPaymentEnv($value)
    {
        try {
            $domain = 'main';
            $path = base_path('storage/app/payment.json');
            if (file_exists($path)) {
                $data = json_decode(file_get_contents($path), true);
                $settings = new \stdClass;
                if (!empty($data)) {
                    foreach (array_keys($data) as $property) {
                        $settings->{$property} = $data[$property];
                    }
                }
                return $settings->$domain[$value] ?? '';
            } else {
                return '';
            }
        } catch (\Throwable $th) {
            return "false";
        }
    }
}

if (!function_exists('GeneratePaymentSetting')) {
    function GeneratePaymentSetting($domain)
    {
        $path = Storage::path('payment.json');
        $settings = PaymentMethodCredential::first()->makeHidden(['id', 'created_at', 'updated_at'])->toArray();
        $new_setting = new \stdClass;
        foreach ($settings as $key => $value) {
            $new_setting->{$key} = $value;
        }
        if (!Storage::has('payment.json')) {
            $strJsonFileContents = null;
        } else {
            $strJsonFileContents = file_get_contents($path);

        }
        $file_data = json_decode($strJsonFileContents, true);
        $setting_array[$domain] = $new_setting;
        if (!empty($file_data)) {
            $merged_array = array_merge($file_data, $setting_array);
        } else {
            $merged_array = $setting_array;
        }
        $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
        file_put_contents($path, $merged_array);

    }
}
if (!function_exists('SaasEnvSetting')) {
    function SaasEnvSetting($domain, $key, $value)
    {
        $path = Storage::path('saas_env.json');
        if (!Storage::has('saas_env.json')) {
            $strJsonFileContents = null;
        } else {
            $strJsonFileContents = file_get_contents($path);
        }
        $file_data = json_decode($strJsonFileContents, true);
        if ($file_data) {
            if (in_array($domain, array_keys($file_data))) {
                $existing_data = $file_data[$domain];
                $existing_data[$key] = $value;
                $new_setting = new \stdClass;
                foreach ($existing_data as $key => $data) {
                    $new_setting->{$key} = $data;
                }
                $setting_array[$domain] = $new_setting;
                $merged_array = array_merge($file_data, $setting_array);
                $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
                file_put_contents($path, $merged_array);
            } else {
                $existing_data = [];
                $existing_data[$key] = $value;
                $new_setting = new \stdClass;
                foreach ($existing_data as $key => $data) {
                    $new_setting->{$key} = $data;
                }
                $setting_array[$domain] = $new_setting;
                $merged_array = array_merge($file_data, $setting_array);
                $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
                file_put_contents($path, $merged_array);
            }


        } else {
            $new_setting = new \stdClass;
            $new_setting->{$key} = $value;
            $setting_array[$domain] = $new_setting;
            if (!empty($file_data)) {
                $merged_array = array_merge($file_data, $setting_array);
                $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
            } else {
                $merged_array = json_encode($setting_array, JSON_PRETTY_PRINT);
            }
            file_put_contents($path, $merged_array);
        }

    }
}

if (!function_exists('saasEnv')) {
    function saasEnv($value, $default = null)
    {
        try {
            if (empty($value)) {
                $value = $default;
            }
            $domain = SaasDomain();
            $path = base_path('storage/app/saas_env.json');
            if (file_exists($path)) {
                $data = json_decode(file_get_contents($path), true);
                $settings = new \stdClass;
                if (!empty($data)) {
                    foreach (array_keys($data) as $property) {
                        $settings->{$property} = $data[$property];
                    }
                }

            }

            $env = $settings->$domain[$value] ?? '';
        } catch (\Throwable $th) {
            $env = null;
        }

        if (empty($env)) {
            $env = $default;
        }
        return $env;
    }
}
if (!function_exists('hasActiveSaasPlan')) {
    function hasActiveSaasPlan()
    {
        try {
            if (SaasDomain() != 'main') {
                $institute_id = SaasInstitute()->id;
                $active_plan = SaasInstitutePlanManagement::on(config('database.default'))->where('lms_id', $institute_id)->where('validity', 1)->first();
                if ($active_plan) {
                    if ($active_plan->unlimited == 1) {
                        return true;
                    }
                    $today = Carbon::now();
                    $service_end_date = Carbon::createFromFormat('Y-m-d H:i:s', $active_plan->service_end_date);
                    $result = $today->gt($service_end_date);
                    if (!$result) {
                        return true;
                    }
                }
                return false;
            } else {
                return true;
            }
        } catch (\Exception $exception) {
            return false;
        }
    }
}
if (!function_exists('saasPlanCheck')) {
    function saasPlanCheck($value, $count = null)
    {
        try {
            if (SaasDomain() != 'main') {
                $institute_id = SaasInstitute()->id;
                $active_plan = SaasInstitutePlanManagement::on(config('database.default'))->where('lms_id', $institute_id)->where('validity', 1)->first();

                if ($active_plan) {
                    if (isModuleActive('LmsSaasMD')) {
                        switch ($value) {
                            case('student'):
                                if (!$active_plan->student_access) {
                                    return true;
                                }
                                break;
                            case('instructor'):
                                if (!$active_plan->instructor_access) {
                                    return true;
                                }
                                break;
                            case('course'):
                                if (!$active_plan->course_access) {
                                    return true;
                                }
                                break;
                            case('meeting'):
                                if (!$active_plan->meeting_access) {
                                    return true;
                                }
                                break;
                            case('quiz'):
                                if (!$active_plan->quiz_access) {
                                    return true;
                                }
                                break;
                            case('blog_post'):
                                if (!$active_plan->blog_access) {
                                    return true;
                                }
                                break;

                        }
                    }


                    $today = Carbon::now();
                    $service_end_date = Carbon::createFromFormat('Y-m-d H:i:s', $active_plan->service_end_date);
                    $result = $today->gt($service_end_date);
                    if ($active_plan->unlimited == 1) {
                        $result = false;
                    }
                    if (!$result) {

                        $checkout = SaasCheckout::on(config('database.default'))->with('plan')->where('lms_id', $institute_id)->get();

                        if ($value == 'quiz') {
                            $plan_limit_value = 'quiz_question_limit';
                        } else {
                            $plan_limit_value = $value . '_limit';
                        }

                        foreach ($checkout as $check) {
                            if ($check->plan->$plan_limit_value == 0) {
                                return false;
                            }
                        }


                        if ($active_plan->{$value} > 0) {
                            if ($value == 'quiz') {
                                if ($count <= $active_plan->{$value}) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } elseif ($value == 'upload_limit') {
                                if ($count <= $active_plan->{$value}) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                if ($active_plan->{$value} > 0) {
                                    return false;
                                } else {
                                    return true;
                                }
                            }
                        } else {
                            return true;
                        }
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }

            } else {
                return false;
            }


        } catch (\Throwable $th) {
            return true;
        }
    }
}
if (!function_exists('saasPlanManagement')) {
    function saasPlanManagement($feature, $type, $size = null)
    {

        if (SaasDomain() != 'main') {
            $institute_id = SaasInstitute()->id;
            $active_plan = SaasInstitutePlanManagement::on(config('database.default'))->where('lms_id', $institute_id)->where('validity', 1)->first();
            if ($feature == 'upload_limit') {
                if ($type == 'create') {
                    $active_plan->{$feature} = $active_plan->{$feature} -= $size;
                }
                if ($type == 'delete') {
                    $active_plan->{$feature} = $active_plan->{$feature} += $size;
                }
            }
            if ($type == 'create') {
                $active_plan->{$feature} = $active_plan->{$feature} -= 1;
            }
            if ($type == 'delete') {
                $active_plan->{$feature} = $active_plan->{$feature} += 1;
            }
            if ($active_plan->{$feature} < 0) {
                $active_plan->{$feature} = 0;
            }
            $active_plan->save();
        }
    }
}

if (!function_exists('saasDb')) {
    function saasDb($value)
    {

        try {

            $domain = SaasDomain();
            $path = base_path('storage/app/saas_db.json');

            if (file_exists($path)) {

                $data = json_decode(file_get_contents($path), true);
                $settings = new \stdClass;
                if (!empty($data)) {
                    foreach (array_keys($data) as $property) {
                        $settings->{$property} = $data[$property];
                    }
                }

            }

            return $settings->$domain[$value] ?? null;
        } catch (\Throwable $th) {
            return null;
        }
    }
}

if (!function_exists('SaasDbSetting')) {
    function SaasDbSetting($domain, $key, $value)
    {
        $path = Storage::path('saas_db.json');
        if (!Storage::has('saas_db.json')) {
            $data = \App\Models\LmsInstitute::get(['db_database', 'db_username', 'db_password', 'domain']);
            $content = [];
            foreach ($data as $row) {
                $content[$row->domain] = [
                    "DB_DATABASE" => $row->domain == 'main' ? env('DB_DATABASE') : $row->db_database,
                    "DB_USERNAME" => $row->domain == 'main' ? env('DB_USERNAME') : $row->db_username,
                    "DB_PASSWORD" => $row->domain == 'main' ? env('DB_PASSWORD') : $row->db_password,
                ];

            }
            file_put_contents($path, json_encode($content, JSON_PRETTY_PRINT));
            $strJsonFileContents = null;
        } else {
            $strJsonFileContents = file_get_contents($path);
        }
        $file_data = json_decode($strJsonFileContents, true);

        if ($file_data) {
            if (in_array($domain, array_keys($file_data))) {
                $existing_data = $file_data[$domain];
                $existing_data[$key] = $value;
                $new_setting = new \stdClass;
                foreach ($existing_data as $key => $data) {
                    $new_setting->{$key} = $data;
                }
                $setting_array[$domain] = $new_setting;
                $merged_array = array_merge($file_data, $setting_array);
                $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
                file_put_contents($path, $merged_array);
            } else {
                $existing_data = [];
                $existing_data[$key] = $value;
                $new_setting = new \stdClass;
                foreach ($existing_data as $key => $data) {
                    $new_setting->{$key} = $data;
                }
                $setting_array[$domain] = $new_setting;
                $merged_array = array_merge($file_data, $setting_array);
                $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
                file_put_contents($path, $merged_array);
            }


        } else {

            $new_setting = new \stdClass;
            $new_setting->{$key} = $value;
            $setting_array[$domain] = $new_setting;
            if (!empty($file_data)) {
                $merged_array = array_merge($file_data, $setting_array);
                $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
            } else {
                $merged_array = json_encode($setting_array, JSON_PRETTY_PRINT);
            }
            file_put_contents($path, $merged_array);
        }

    }
}

if (!function_exists('DbConnect')) {
    function DbConnect()
    {
        DB::setDefaultConnection('mysql_md');
        DB::purge('mysql_md');
        DB::reconnect('mysql_md');
    }
}




