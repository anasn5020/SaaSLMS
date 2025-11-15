<?php

Route::prefix('pesapal')->middleware(['auth','student'])->group(function () {
    Route::get('/', 'PesapalController@index');
    Route::get('/success', 'PesapalController@success')->name('pesapalSuccess');
});
