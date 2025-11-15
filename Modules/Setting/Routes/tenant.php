<?php

use Illuminate\Support\Facades\Route;
use Modules\Setting\Http\Controllers\AnalyticsToolController;
use Modules\Setting\Http\Controllers\MediaManagerController;
use Modules\Setting\Http\Controllers\PushSettingController;
use Modules\Setting\Http\Controllers\StorageController;

Route::group(['prefix' => 'admin/settings', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    //payout account
    Route::resource('payout-accounts', 'PayoutAccountController')->names([
        'index' => 'payout_accounts.index',
        'create' => 'payout_accounts.create',
        'store' => 'payout_accounts.store',
        'show' => 'payout_accounts.show',
        'edit' => 'payout_accounts.edit',
        'update' => 'payout_accounts.update'
    ])->except(['destroy']);
    Route::get('payout-account/{id}/delete', 'PayoutAccountController@destroy')->name('payout_accounts.destroy');
    Route::get('user/{id}/payout-account', 'PayoutAccountController@userPayoutAccount')->name('user_payout_accounts.show');

    Route::get('payout', 'PayoutAccountController@settings')->name('payout.settings');
    Route::post('payout-submit', 'PayoutAccountController@settingsSubmit')->name('payout.settings.submit');

});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    //sms settings
    Route::resource('sms-settings', 'SmsSettingsController')->names([
        'index' => 'sms_settings.index',
        'create' => 'sms_settings.create',
        'store' => 'sms_settings.store',
        'show' => 'sms_settings.show',
        'edit' => 'sms_settings.edit',
        'update' => 'sms_settings.update'
    ])->except(['destroy']);
    Route::post('sms-setting/status', 'SmsSettingsController@status')->name('sms_settings.status');
    Route::get('sms-setting/{id}/delete', 'SmsSettingsController@destroy')->name('sms_settings.destroy');
    Route::post('/test-sms-send', 'SmsSettingsController@sendTestSms')->name('send_test_sms');

});


Route::group(['prefix' => 'gamification', 'middleware' => ['auth', 'student']], function () {
    Route::get('/reward-point', 'RewardPointController@index')->name('student.gamification.reward');
});
Route::group(['prefix' => 'gamification', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/setting', 'GamificationController@index')->name('gamification.setting')->middleware('RoutePermissionCheck:gamification.setting');
    Route::post('/setting', 'GamificationController@update')->name('gamification.setting.update')->middleware('RoutePermissionCheck:gamification.setting.update');
    Route::post('/setting-reset', 'GamificationController@reset')->name('gamification.setting.reset')->middleware('RoutePermissionCheck:gamification.setting.reset');
    Route::get('/statistic-reset', 'GamificationController@statisticResetModal')->name('gamification.reset.statistic')->middleware('RoutePermissionCheck:gamification.reset.statistic');
    Route::post('/statistic-reset', 'GamificationController@statisticReset')->name('gamification.reset.statistic')->middleware('RoutePermissionCheck:gamification.reset.statistic');

    Route::get('/badges', 'BadgeController@index')->name('gamification.badges')->middleware('RoutePermissionCheck:gamification.badges');
    Route::post('/badges', 'BadgeController@store')->name('gamification.badges.store')->middleware('RoutePermissionCheck:gamification.badges.store');
    Route::get('/badges-edit/{id}', 'BadgeController@edit')->name('gamification.badges.edit')->middleware('RoutePermissionCheck:gamification.badges.update');
    Route::post('/badges-edit', 'BadgeController@update')->name('gamification.badges.update')->middleware('RoutePermissionCheck:gamification.badges.update');
    Route::get('/badges-delete/{id}', 'BadgeController@destroy')->name('gamification.badges.delete')->middleware('RoutePermissionCheck:gamification.badges.delete');

    Route::get('/history', 'GamificationHistoryController@index')->name('gamification.history')->middleware('RoutePermissionCheck:gamification.history');
    Route::get('/history-data', 'GamificationHistoryController@data')->name('gamification.historyData')->middleware('RoutePermissionCheck:gamification.history');
    Route::get('/history-details/{type}/{id}', 'GamificationHistoryController@history_details')->name('gamification.history_details')->middleware('RoutePermissionCheck:gamification.history');

});
Route::group(['prefix' => 'setting', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'SettingController@index')->name('setting.index');
    Route::get('/activation', 'SettingController@activation')->name('setting.activation')->middleware('RoutePermissionCheck:setting.activation');
    Route::get('/general-settings', 'SettingController@general_settings')->name('setting.general_settings')->middleware('RoutePermissionCheck:setting.general_settings');
    Route::get('/email-configaration', 'SettingController@email_setup')->name('setting.email_setup')->middleware('RoutePermissionCheck:setting.email_setup');
    Route::get('/seo-setup', 'SettingController@seo_setting')->name('setting.seo_setting')->middleware('RoutePermissionCheck:setting.seo_setting');
    Route::get('/payment-setup', 'SettingController@paymentSetup')->name('setting.paymentSetup')->middleware('RoutePermissionCheck:route_name');
    Route::get('/social-login-setup', 'SettingController@social_login_setup')->name('setting.social_login_setup')->middleware('RoutePermissionCheck:setting.social_login_setup');
    Route::post('/update-activation-status', 'SettingController@update_activation_status')->name('update_activation_status')->middleware('RoutePermissionCheck:settings.ChangeActivationStatus');

    Route::post('general-settings/update', 'GeneralSettingsController@update')->name('company_information_update')
        ->middleware('RoutePermissionCheck:settings.general_setting_update|blogs.setting.index');

    Route::get('general-settings/remove_icon', 'GeneralSettingsController@remove_icon')->name('setting.remove_icon')->middleware('RoutePermissionCheck:settings.general_setting_update');
    Route::post('smtp-gateway-credentials/update', 'GeneralSettingsController@smtp_gateway_credentials_update')->name('smtp_gateway_credentials_update');
    Route::post('/test-mail/send', 'GeneralSettingsController@test_mail_send')->name('test_mail.send')->middleware('RoutePermissionCheck:setting.send_test_mail');
    Route::post('/social_login', 'GeneralSettingsController@socialCreditional')->name('socialCreditional')->middleware('RoutePermissionCheck:setting.setting.social_login_setup_update');
    Route::post('/seo-setup', 'GeneralSettingsController@seoSetting')->name('seo_setup')->middleware('RoutePermissionCheck:setting.seo_setting_update');

    Route::get('/student-setup', 'SettingController@student_setup')->name('settings.student_setup')->middleware('RoutePermissionCheck:settings.student_setup');
    Route::post('/student-setup', 'SettingController@student_setup_update')->name('settings.student_setup_update')->middleware('RoutePermissionCheck:settings.student_setup_update');

    Route::get('/instructor-setup', 'SettingController@instructor_setup')->name('settings.instructor_setup')->middleware('RoutePermissionCheck:settings.instructor_setup');
    Route::post('/instructor-setup', 'SettingController@instructor_setup_update')->name('settings.instructor_setup_update')->middleware('RoutePermissionCheck:settings.instructor_setup');


    Route::get('/footerEmailConfig', 'GeneralSettingsController@footerEmailConfig')->name('footerEmailConfig')->middleware('RoutePermissionCheck:footerEmailConfig');
    Route::get('/EmailTemp', 'GeneralSettingsController@EmailTemp')->name('EmailTemp')->middleware('RoutePermissionCheck:EmailTemp');

    Route::get('/EmailTempAjax/{id}/{type}', 'GeneralSettingsController@EmailTempAjax')->name('EmailTempAjax')->middleware('RoutePermissionCheck:EmailTemp');


    Route::resource('currencies', 'CurrencyController')->except('destroy')->middleware('RoutePermissionCheck:currencies.index');
    Route::post('currency-setting-update', 'SettingController@update_settings')->name('currencies.update_settings')->middleware('RoutePermissionCheck:currencies.index');
    Route::post('currency-edit-modal', 'CurrencyController@edit_modal')->name('currencies.edit_modal')->middleware('RoutePermissionCheck:currencies.edit_modal');
    Route::get('/currencies/destroy/{id}', 'CurrencyController@destroy')->name('currencies.destroy')->middleware('RoutePermissionCheck:currencies.destroy');


    Route::get('/aboutSystem', 'GeneralSettingsController@aboutSystem')->name('setting.aboutSystem')->middleware('RoutePermissionCheck:setting.aboutSystem');
    Route::get('/updateSystem', 'UpdateController@updateSystem')->name('setting.updateSystem')->middleware('RoutePermissionCheck:setting.updateSystem', 'saasAdmin');
    Route::post('/updateSystem', 'UpdateController@updateSystemSubmit')->name('setting.updateSystem.submit')->middleware('RoutePermissionCheck:setting.updateSystem.submit', 'saasAdmin');


    Route::resource('ipBlock', 'IpBlockController')->except('destroy')->middleware('RoutePermissionCheck:ipBlock.index', 'saasAdmin');
    Route::post('ipBlock-delete', 'IpBlockController@destroy')->name('ipBlockDelete')->middleware('RoutePermissionCheck:ipBlock.index', 'saasAdmin');

    Route::get('/geo-location', 'GeoLocationController@index')->name('setting.geoLocation')->middleware('RoutePermissionCheck:setting.geoLocation');
    Route::get('/geo-location-data', 'GeoLocationController@data')->name('setting.geoLocation.data')->middleware('RoutePermissionCheck:setting.geoLocation');
    Route::post('/geo-location-delete', 'GeoLocationController@destroy')->name('setting.geoLocation.delete')->middleware('RoutePermissionCheck:setting.geoLocation');
    Route::post('/geo-location-empty', 'GeoLocationController@EmptyLog')
        ->name('setting.geoLocation.empty')
        ->middleware('RoutePermissionCheck:setting.geoLocation');


    Route::get('/cron-job', 'CornJobController@index')->name('setting.cronJob')->middleware('RoutePermissionCheck:setting.cronJob');


    Route::get('/cookie-setting', 'CookieSettingController@index')
        ->name('setting.cookieSetting')
        ->middleware('RoutePermissionCheck:setting.cookieSetting');

    Route::post('/cookie-setting', 'CookieSettingController@store')
        ->name('setting.cookieSettingStore')
        ->middleware('RoutePermissionCheck:setting.cookieSetting');


    Route::get('/cache-setting', 'CacheSettingController@index')
        ->name('setting.cacheSetting')
        ->middleware('RoutePermissionCheck:setting.cacheSetting');

    Route::post('/cache-setting', 'CacheSettingController@store')
        ->name('setting.cacheSettingStore')
        ->middleware('RoutePermissionCheck:setting.cacheSetting');

    Route::resource('timezone', 'TimezoneController')->except('destroy')->middleware('RoutePermissionCheck:timezone.index');
    Route::post('timezone-edit-modal', 'TimezoneController@edit_modal')->name('timezone.edit_modal')->middleware('RoutePermissionCheck:timezone.update');
    Route::get('/timezone/destroy/{id}', 'TimezoneController@destroy')->name('timezone.destroy')->middleware('RoutePermissionCheck:timezone.delete');


    Route::resource('city', 'CityController')->except('destroy')->middleware('RoutePermissionCheck:city.index');
    Route::post('city-edit-modal', 'CityController@edit_modal')->name('city.edit_modal')->middleware('RoutePermissionCheck:city.index');
    Route::get('/city/destroy/{id}', 'CityController@destroy')->name('city.destroy')->middleware('RoutePermissionCheck:city.index');


    Route::get('/maintenance', 'SettingController@maintenance')
        ->name('setting.maintenance')
        ->middleware('RoutePermissionCheck:setting.maintenance', 'saasAdmin');

    Route::post('/maintenance', 'SettingController@maintenanceAction')
        ->middleware('RoutePermissionCheck:setting.maintenance', 'saasAdmin');


    Route::get('/utilities', 'UtilitiesController@index')
        ->name('setting.utilities')
        ->middleware('RoutePermissionCheck:setting.utilities', 'saasAdmin');

    Route::post('utilities/reset-database', 'UtilitiesController@resetDatabase')->name('utilities.resetDatabase')->middleware(['RoutePermissionCheck:utilities.resetDatabase']);
    Route::post('utilities/import-demo-database', 'UtilitiesController@importDemoDatabase')->name('utilities.importDemoDatabase')->middleware(['RoutePermissionCheck:utilities.importDemoDatabase']);


    Route::get('/captcha', 'SettingController@captcha')
        ->name('setting.captcha')
        ->middleware('RoutePermissionCheck:setting.captcha');

    Route::post('/captcha', 'SettingController@captchaStore')
        ->middleware('RoutePermissionCheck:setting.captcha');


    Route::get('/socialLogin', 'SettingController@socialLogin')
        ->name('setting.socialLogin')
        ->middleware('RoutePermissionCheck:setting.socialLogin');

    Route::post('/socialLogin', 'SettingController@socialLoginStore')
        ->middleware('RoutePermissionCheck:setting.socialLogin');


    Route::get('/error_log', 'ErrorLogController@index')
        ->name('setting.error_log')
        ->middleware('RoutePermissionCheck:setting.error_log');


    Route::get('/error_log_data', 'ErrorLogController@getAllErrorLogData')
        ->name('setting.getAllErrorLogData')
        ->middleware('RoutePermissionCheck:setting.error_log');

    Route::post('/error_log_data', 'ErrorLogController@DeleteErrorLog')
        ->name('setting.error_log.delete')
        ->middleware('RoutePermissionCheck:setting.error_log');

    Route::post('/error_log_empty', 'ErrorLogController@EmptyErrorLog')
        ->name('setting.error_log.empty')
        ->middleware('RoutePermissionCheck:setting.error_log');


    Route::get('/push-notification', 'PushNotificationController@pushNotification')
        ->name('setting.pushNotification')
        ->middleware('RoutePermissionCheck:setting.pushNotification');

    Route::post('/push-notification', 'PushNotificationController@pushNotificationSubmit')
        ->middleware('RoutePermissionCheck:setting.pushNotification');

    Route::get('/queue-setting', 'QueueSettingController@index')
        ->name('setting.queueSetting')
        ->middleware('RoutePermissionCheck:setting.queueSetting');

    Route::post('/queue-setting', 'QueueSettingController@store')
        ->name('setting.queueSettingStore')
        ->middleware('RoutePermissionCheck:setting.queueSetting');

    Route::get('/preloader-setting', 'PreloaderSettingController@index')
        ->name('setting.preloader')
        ->middleware('RoutePermissionCheck:setting.preloader');

    Route::post('/preloader-setting', 'PreloaderSettingController@store')
        ->name('setting.preloaderStore')
        ->middleware('RoutePermissionCheck:setting.preloader');


    Route::get('/gdrive', 'GoogleDriveController@index')->name('gdrive.setting')->middleware(['RoutePermissionCheck:gdrive.setting']);
    Route::post('/gdrive', 'GoogleDriveController@update')->name('gdrive.setting.update')->middleware(['RoutePermissionCheck:gdrive.setting']);
    Route::get('/login/google', 'GoogleDriveController@redirecttogoogleprovider')->name('setting.google.login');
    Route::get('/logout/google', 'GoogleDriveController@googlelogout')->name('setting.google.logout');
    Route::get('login/google/callback', 'GoogleDriveController@handleProviderGoogleCallback')->name('setting.google.callback');


    Route::get('/migration', 'SettingController@migration')->name('setting.migration');
    Route::post('/migration', 'SettingController@migrationSubmit');


    Route::get('/pusher-setting', [PushSettingController::class, 'index'])->name('pusher.setting')->middleware('RoutePermissionCheck:pusher.setting');
    Route::post('/pusher-setting', [PushSettingController::class, 'store'])->middleware('RoutePermissionCheck:pusher.setting');

});


Route::group(['prefix' => 'media-manager', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', [MediaManagerController::class, 'index'])->name('setting.media-manager.index');
    Route::get('/create', [MediaManagerController::class, 'create'])->name('setting.media-manager.create');
    Route::post('/create', [MediaManagerController::class, 'store'])->name('setting.media-manager.store');
    Route::get('/delete-media-file/{id}', [MediaManagerController::class, 'destroy'])->name('setting.media-manager.delete');
    Route::get('/get-files-modal', [MediaManagerController::class, 'getfilesForModal'])->name('setting.media-manager.get_files_for_modal');
    Route::post('/get-modal', [MediaManagerController::class, 'getModal'])->name('setting.media-manager.get_media_modal');
    Route::post('/get_media_by_id', [MediaManagerController::class, 'getMediaById'])->name('setting.media-manager.get_media_by_id');
    Route::post('/bulk-delete', [MediaManagerController::class, 'mediaBulkDelete'])->name('setting.media-manager.bulk_delete');


    Route::get('/setting', [MediaManagerController::class, 'setting'])->name('setting.media-manager.setting');
    Route::post('/setting', [MediaManagerController::class, 'settingUpdate'])->name('setting.media-manager.settingUpdate');


});
Route::group(['prefix' => 'setting', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/analytics', [AnalyticsToolController::class, 'index'])->name('settings.analytics.index')->middleware('RoutePermissionCheck:settings.analytics.index');
    Route::post('/analytics', [AnalyticsToolController::class, 'update'])->name('settings.analytics.update')->middleware('RoutePermissionCheck:settings.analytics.index');
});
