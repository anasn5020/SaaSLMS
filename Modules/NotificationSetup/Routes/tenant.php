<?php

Route::prefix('notification-setup')->middleware(['auth'])->group(function () {
    Route::get('/', 'NotificationSetupController@index')->name('notification_setup_list')->middleware('RoutePermissionCheck:notification_setup_list');
    Route::post('/', 'NotificationSetupController@setup')->name('update_notification_setup');
    Route::post('/browser-message', 'NotificationSetupController@UpdateBrowserMsg')->name('updateBrowserMessage')->middleware('RoutePermissionCheck:updateBrowserMessage');
    Route::get('/users-notifications', 'NotificationSetupController@UserNotificationControll')->name('UserNotificationControll')->middleware('RoutePermissionCheck:UserNotificationControll');
    Route::post('/users-notifications', 'NotificationSetupController@UpdateUserNotificationControll')->name('UpdateUserNotificationControll')->middleware('RoutePermissionCheck:UpdateUserNotificationControll');

    Route::post('/sms-message', 'NotificationSetupController@updateSmsMsg')->name('updateSmsMessage')->middleware('RoutePermissionCheck:updateSmsMessage');
    Route::get('/my-notifications', 'NotificationSetupController@MyNotification')->name('MyNotification');
});

Route::prefix('notifications')->name('notifications.')->middleware(['auth'])->group(function () {
    Route::get('/send', 'PostedNotificationController@create')->name('posted.create');
    Route::post('/send', 'PostedNotificationController@store')->name('posted.store');
    Route::get('/posted', 'PostedNotificationController@index')->name('posted.index');
    Route::get('/posted/datatable', 'PostedNotificationController@postedDatatable')->name('posted.datatable');
    Route::post('/delete', 'PostedNotificationController@destroy')->name('posted.destroy');
});
