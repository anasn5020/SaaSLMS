<?php

Route::prefix('mobilpay')->middleware(['auth'])->group(function () {
    Route::get('/return', 'MobilpayController@return')->middleware(['auth']);
});
Route::post('mobilpay/confirm/booking', 'MobilpayController@confirmBooking');
Route::post('mobilpay/confirm/deposit', 'MobilpayController@confirmDeposit');
Route::post('mobilpay/confirm/payment', 'MobilpayController@confirmPayment');
