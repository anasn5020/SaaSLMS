<?php

use Illuminate\Support\Facades\Route;

Route::prefix('certificate')->middleware('auth')->group(function () {
    Route::resource('certificate', 'CertificateController')->except('update')->middleware('RoutePermissionCheck:certificate.index');
    Route::get('certificate-clone/{id}', 'CertificateController@clone')->name('certificate.clone')->middleware('RoutePermissionCheck:certificate.clone');
    Route::post('certificate-update/{id}', 'CertificateController@update')->name('certificate.update')->middleware('RoutePermissionCheck:certificate.edit');
    Route::post('certificate-course/{id}', 'CertificateController@courseCertificate')->name('course.certificate.update')->middleware('RoutePermissionCheck:certificate.index');
    Route::post('certificate-quiz/{id}', 'CertificateController@quizCertificate')->name('quiz.certificate.update')->middleware('RoutePermissionCheck:certificate.index');
    Route::post('certificate-class/{id}', 'CertificateController@classCertificate')->name('class.certificate.update')->middleware('RoutePermissionCheck:certificate.index');
    Route::post('get-fonts/variant', 'CertificateController@getVariants')->name('get.fonts.variant');
    Route::get('view/{id}', 'CertificateController@view')->name('certificate.view');
    Route::get('download/{id}', 'CertificateController@download')->name('certificate.download');

    Route::get('make', 'CertificateController@preview')->name('certificate.make');
    Route::post('upload', 'CertificateController@upload')->name('certificate.upload');


    Route::get('fonts', 'CertificateController@allfonts')->name('certificate.fonts')->middleware('RoutePermissionCheck:certificate.fonts');
    Route::post('fonts', 'CertificateController@saveFont')->name('certificate.fonts.save')->middleware('RoutePermissionCheck:certificate.fonts.save');
    Route::post('fonts/delete', 'CertificateController@deleteFont')->name('certificate.fonts.delete')->middleware('RoutePermissionCheck:certificate.fonts.delete');


    Route::get('setting', 'CertificateSettingController@index')->name('certificate.setting')->middleware('RoutePermissionCheck:certificate.setting');
    Route::post('setting', 'CertificateSettingController@store')->middleware('RoutePermissionCheck:certificate.setting');

});

Route::post('certificate/get-by-ajax', 'CertificateController@getByAjax');
