<?php

Route::prefix('newsletter')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/setting', 'NewsletterController@setting')->name('newsletter.setting')->middleware('RoutePermissionCheck:newsletter.setting');
    Route::post('/setting-update', 'NewsletterController@update')->name('newsletter.setting.update')->middleware('RoutePermissionCheck:newsletter.setting');
    Route::get('/mailchimp/setting', 'MailchimpController@setting')->name('newsletter.mailchimp.setting')->middleware('RoutePermissionCheck:newsletter.mailchimp.setting');
    Route::post('/mailchimp/setting', 'MailchimpController@settingStore')->name('newsletter.mailchimp.settingStore')->middleware('RoutePermissionCheck:newsletter.mailchimp.settingStore');
    Route::get('/getresponse/setting', 'GetResponseController@setting')->name('newsletter.getresponse.setting')->middleware('RoutePermissionCheck:newsletter.getresponse.setting');
    Route::post('/getresponse/setting', 'GetResponseController@settingStore')->name('newsletter.getresponse.settingStore')->middleware('RoutePermissionCheck:newsletter.getresponse.settingStore');
    Route::get('subscriber', 'NewsletterController@subscriber')->name('newsletter.subscriber')->middleware('RoutePermissionCheck:newsletter.subscriber');
    Route::get('subscriber_delete/{id}', 'NewsletterController@subscriberDelete')->name('newsletter.subscriberDelete')->middleware('RoutePermissionCheck:newsletter.subscriberDelete');

    Route::get('/acelle/setting', 'AcelleController@setting')->name('newsletter.acelle.setting')->middleware('RoutePermissionCheck:newsletter.acelle.setting');
    Route::post('/acelle/setting', 'AcelleController@settingStore')->name('newsletter.acelle.settingStore')->middleware('RoutePermissionCheck:newsletter.acelle.setting');
});
