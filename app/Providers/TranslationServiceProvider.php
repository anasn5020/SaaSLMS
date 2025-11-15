<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        view()->composer('*', function ($view) {
            $view->with(['jsonLang' => $this->getTranslations()]);
        });
    }

    private function getTranslations()
    {

        $locale = app()->getLocale();
        $domain = SaasDomain();

        return Cache::rememberForever('translations' . $locale . $domain, function () use ($locale) {
            return $this->jsonTranslations($locale);
        });
    }

    private function jsonTranslations($locale)
    {
        $files[] = resource_path('lang/' . $locale . '/data.php');
        if (isModuleActive('Chat')) {
            $files[] = resource_path('lang/' . $locale . '/chat.php');
        }


        $lang = [];
        foreach ($files as $file) {
            if (file_exists($file) && is_array(include($file))) {
                $lang = array_merge($lang, include($file));
            }
        }


        if (!json_encode($lang, true)) {
            return json_encode($lang, JSON_INVALID_UTF8_IGNORE);
        }
        return json_encode($lang, true);
    }
}
