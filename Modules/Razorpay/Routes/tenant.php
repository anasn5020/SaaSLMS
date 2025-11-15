<?php


Route::prefix('razorpay')->middleware(['auth','student'])->group(function() {
    Route::get('/', 'RazorpayController@index');
    Route::get('/pay', 'RazorpayController@create')->name('paywithrazorpay');
    Route::post('/payment', 'RazorpayController@payment')->name('razorpayPayment');
});
