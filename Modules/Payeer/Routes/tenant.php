<?php

Route::prefix('payeer')->middleware(['auth','student'])->group(function () {
    Route::get('/callback-success', 'PayeerController@paymentSuccess')->name('payeerPaymentSuccess');
    Route::get('/callback-failed', 'PayeerController@paymentFailed')->name('payeerPaymentfailed');
});
