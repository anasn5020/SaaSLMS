<?php

Route::prefix('vdocipher')->group(function () {
    Route::get('/setting', 'VdoCipherController@setting')->name('vdocipher.setting');
    Route::post('/setting', 'VdoCipherController@settingUpdate')->name('vdocipher.settingUpdate');
});
