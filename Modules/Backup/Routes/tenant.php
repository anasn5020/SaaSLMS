<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/backup', 'BackupController@index')->name('backup.index')->middleware('RoutePermissionCheck:backup.index','saasAdmin');
    Route::get('/backup/create', 'BackupController@create')->name('backup.create')->middleware('RoutePermissionCheck:backup.create');
    Route::get('/backup/delete/{dir}', 'BackupController@delete')->name('backup.delete')->middleware('RoutePermissionCheck:backup.delete');
    Route::post('/import', 'BackupController@import')->name('backup.import')->middleware('RoutePermissionCheck:backup.import');
});

