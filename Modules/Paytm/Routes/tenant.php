<?php

Route::prefix('paytm')->middleware(['auth'])->group(function () {
    Route::get('/', 'PaytmController@index');
    Route::post('/payment/status', 'PaytmController@paymentCallback')->name('paytmStatus');
    Route::post('/deposit/status', 'PaytmController@depositCallback')->name('paytmDepositStatus');
    Route::post('/test/status', 'PaytmController@testCallback')->name('paytmTestStatus');
    Route::post('/subscription/status', 'PaytmController@subscriptionCallback')->name('paytmSubscriptionStatus');
    Route::post('/booking/status', 'PaytmController@bookingCallback')->name('paytmBookingStatus');


    Route::post('/payment', 'PaytmController@pay')->name('paytm.make.payment');
});
