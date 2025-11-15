<?php

Route::prefix('paystack')->middleware(['auth'])->group(function() {
    Route::get('/', 'PayStackController@index');
    Route::post('/pay', 'PayStackController@redirectToGateway')->name('payStack');
    Route::get('/payment/callback', 'PayStackController@handleGatewayCallback')->name('payStackCallBack');  //Make sure you have /payment/callback registered in Paystack Dashboard |  https://dashboard.paystack.com/

});
