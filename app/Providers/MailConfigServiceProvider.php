<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {



        if (isModuleActive('LmsSaas')) {
            $config = array(
                'driver' => saasEnv('MAIL_DRIVER'),
                'host' => saasEnv('MAIL_HOST'),
                'port' => saasEnv('MAIL_PORT'),
                'from' => array('address' => saasEnv('MAIL_FROM_ADDRESS'), 'name' => saasEnv('MAIL_FROM_NAME')),
                'encryption' => saasEnv('MAIL_ENCRYPTION'),
                'username' => saasEnv('MAIL_USERNAME'),
                'password' => saasEnv('MAIL_PASSWORD'),
                'sendmail' => '/usr/sbin/sendmail -bs',
                'pretend' => false,
            );
            Config::set('mail', $config);
        }




    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
