<?php



Route::prefix('modulemanager')->middleware(['auth','admin'])->group(function () {
    Route::get('/', 'ModuleManagerController@ManageAddOns')->name('modulemanager.index');
    Route::post('/uploadModule', 'ModuleManagerController@uploadModule')->name('modulemanager.uploadModule');

    Route::get('manage-adons-delete/{name}', 'ModuleManagerController@ManageAddOns')->name('deleteModule');
    Route::get('manage-adons-enable/{name}', 'ModuleManagerController@moduleAddOnsEnable')->name('moduleAddOnsEnable');
    Route::get('manage-adons-disable/{name}', 'ModuleManagerController@moduleAddOnsDisable')->name('moduleAddOnsDisable');
});
