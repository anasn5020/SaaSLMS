<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin/payment', 'middleware' => ['auth', 'admin']], function () {
    Route::get('commission', 'PaymentController@setCommission')->name('setting.setCommission')->middleware('RoutePermissionCheck:setting.setCommission');

    Route::post('/saveFlat', 'PaymentController@saveFlat')->name('saveFlat')->middleware('RoutePermissionCheck:setting.setCourseFee_update');
    Route::post('/instructor_commission', 'PaymentController@instructor_commission')->name('instructor_commission')->middleware('RoutePermissionCheck:setting.instructorCommission_edit');

    Route::post('/courseCommissionUpdate/', 'PaymentController@courseCommissionUpdate')->middleware('RoutePermissionCheck:setting.courseCommission_update');

    Route::get('/withdraws', 'ReportController@withdraws')->name('withdraws')->middleware('RoutePermissionCheck:instructor_payout');

    Route::post('/courseCommission', 'PaymentController@courseCommission')->name('courseCommission');
    Route::get('/courseCommission/{id}/delete', 'PaymentController@courseCommissionDelete')->name('setting.courseCommission.delete')->middleware('RoutePermissionCheck:setting.courseCommission.delete');
    Route::get('/online-payment-received', 'ReportController@onlineLog')->name('onlineLog')->middleware('RoutePermissionCheck:onlineLog');

    Route::post('/filterSearch', 'ReportController@filterSearch')->name('filterSearch');
    Route::post('/filterSearchByMethod', 'ReportController@filterMethod');

    Route::get('/set-payout', 'PaymentController@setPayout')->name('set.payout');
    Route::post('/set-payout/email', 'PaymentController@savePayout')->name('save.payout.email');
});



