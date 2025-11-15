<?php

Route::prefix('popup-content')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'PopupContentController@index')->name('popup-content.index')->middleware('RoutePermissionCheck:popup-content.index');
    Route::post('/update', 'PopupContentController@update')->name('popup-content.update')->middleware('RoutePermissionCheck:popup-content.index');
});
