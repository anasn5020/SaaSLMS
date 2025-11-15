<?php

use Illuminate\Support\Facades\Route;
use Modules\VirtualClass\Http\Controllers\CustomMeetingController;
use Modules\VirtualClass\Http\Controllers\MeetingRecordController;


Route::group(['prefix' => 'virtualclass', 'middleware' => ['auth', 'admin']], function () {
    Route::resource('virtual-class', 'VirtualClassController')->middleware('RoutePermissionCheck:virtual-class.index')->except('show','destroy');
    Route::post('virtual-class-delete', 'VirtualClassController@destroy')->name('virtual-class.destroy')->middleware('RoutePermissionCheck:virtual-class.index');
    Route::get('/all/virtual-class-data', 'VirtualClassController@getAllVirtualClassData')->name('getAllVirtualClassData')->middleware('RoutePermissionCheck:virtual-class.index');

    Route::get('virtual-class-setting', 'VirtualClassController@setting')->name('virtual-class.setting')->middleware('RoutePermissionCheck:virtual-class.setting');
    Route::post('virtual-class-setting-update', 'VirtualClassController@settingUpdate')->name('setting.update')->middleware('RoutePermissionCheck:virtual-class.setting');
    Route::get('virtual-class-details/{id}', 'VirtualClassController@details')->name('virtual-class.details')->middleware('RoutePermissionCheck:virtual-class.index');
    Route::get('virtual-class-create/{id}', 'VirtualClassController@createMeeting')->name('virtual-class.createMeeting')->middleware('RoutePermissionCheck:virtual-class.create');

//    Route::post('virtual-class-create/{id}', 'VirtualClassController@createMeetingStore')->name('virtual-class.createMeetingStore')->middleware('RoutePermissionCheck:virtual-class.create');
//    Route::post('bbb-virtual-class-create/{id}', 'VirtualClassController@bbbMeetingStore')->name('virtual-class.bbbMeetingStore')->middleware('RoutePermissionCheck:virtual-class.create');
//    Route::post('jitsi-virtual-class-create/{id}', 'VirtualClassController@jitsiMeetingStore')->name('virtual-class.jitsiMeetingStore')->middleware('RoutePermissionCheck:virtual-class.create');


    Route::get('custom-class-edit/{id}', [CustomMeetingController::class, 'edit'])->name('custom.meetings.edit');
    Route::post('custom-class-edit/{id}', [CustomMeetingController::class, 'update'])->name('custom.meetings.update');
    Route::delete('custom-class-delete/{id}', [CustomMeetingController::class, 'destroy'])->name('custom.meetings.destroy');

    Route::get('class-records/list/{class_id}/{meeting_id}', [MeetingRecordController::class, 'index'])
        ->name('virtual-class.records.index')
        ->middleware('RoutePermissionCheck:virtual-class.index');

    Route::get('class-records/create/{class_id}/{meeting_id}', [MeetingRecordController::class, 'create'])
        ->name('virtual-class.records.create')
        ->middleware('RoutePermissionCheck:virtual-class.index');

    Route::post('class-records/create/{class_id}/{meeting_id}', [MeetingRecordController::class, 'store'])
        ->middleware('RoutePermissionCheck:virtual-class.index');

    Route::delete('class-records/delete/{record_id}', [MeetingRecordController::class, 'delete'])
        ->name('virtual-class.records.delete')
        ->middleware('RoutePermissionCheck:virtual-class.index');

});
Route::group(['prefix' => 'custom', 'middleware' => ['auth']], function () {
    Route::get('class-start/{id}', [CustomMeetingController::class, 'show'])->name('custom.meetings.show');
    Route::post('send-custom-class-message/{id}', [CustomMeetingController::class, 'submitMsg'])->name('custom.meetings.submitMsg');
});
