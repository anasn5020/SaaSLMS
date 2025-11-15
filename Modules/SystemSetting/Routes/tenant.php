<?php

use Illuminate\Support\Facades\Route;

Route::prefix('systemsetting')->group(function () {
    Route::get('/', 'SystemSettingController@index');
    Route::get('/setLocale/{lang}', 'SystemSettingController@setLocale');
    Route::get('/getLocale', 'SystemSettingController@getLocale');
    Route::get('/languages', 'SystemSettingController@languages');
    Route::get('/currencies', 'SystemSettingController@currencies');
    Route::get('/get_language', 'SystemSettingController@getLocaleLang');
});

Route::group(['prefix' => 'admin/systemsetting', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/getAllLanguage', 'SystemSettingController@getAllLanguage');

    Route::get('api-key', 'SystemSettingController@apiKey')->name('api-key.setting');
    Route::post('api-key', 'SystemSettingController@apiKeySave');
});

Route::group(['prefix' => 'admin/systemsetting', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'SystemSettingController@index');

    Route::post('/add_phrase', 'SystemSettingController@addPhrase');
    Route::post('/add_module', 'SystemSettingController@addModule');

    Route::get('/messages', 'InstructorSettingController@toastrMessages');

//    Route::get('/getAllLanguage', 'SystemSettingController@getAllLanguage');
    Route::get('/languageStatus/{id}', 'SystemSettingController@languageStatus');
    Route::post('/language_add', 'SystemSettingController@language_add');
    Route::get('/language_edit/{id}', 'SystemSettingController@language_edit');
    Route::post('/language_update', 'SystemSettingController@language_update');
    Route::post('/language_search', 'SystemSettingController@language_search');
    Route::get('/language_searchData', 'SystemSettingController@language_searchData');
    Route::post('/language_phase', 'SystemSettingController@language_phase');
    Route::get('/language', 'SystemSettingController@language');
    Route::post('/language_delete/{id}', 'SystemSettingController@language_delete');
    Route::get('/changeLanguage/{id}', 'SystemSettingController@changeLanguage');
    Route::get('/allModules', 'SystemSettingController@allModules');
    Route::post('/moduleCode', 'SystemSettingController@moduleCode');
    Route::post('/saveTranslate/{lang}', 'SystemSettingController@saveTranslate');
    Route::post('/socialCreditional', 'SystemSettingController@socialCreditional');

//Instructor Manage
    Route::get('/all/instructor-data', 'InstructorSettingController@getAllInstructorData')->name('getAllInstructorData')->middleware('RoutePermissionCheck:allInstructor');

    Route::get('/allInstructor', 'InstructorSettingController@index')->name('allInstructor')->middleware('RoutePermissionCheck:allInstructor');
    Route::get('/create', 'InstructorSettingController@create')->name('instructor.store')->middleware('RoutePermissionCheck:instructor.store');
    Route::post('/create', 'InstructorSettingController@store')->middleware('RoutePermissionCheck:instructor.store');
    Route::get('/searchInstructor', 'InstructorSettingController@searchInstructor');
    Route::get('/edit/{id}', 'InstructorSettingController@edit')->name('instructor.edit')->middleware('RoutePermissionCheck:instructor.edit');
    Route::get('/instructor/show/{id}', 'InstructorSettingController@show')->name('instructor.show')->middleware('RoutePermissionCheck:allInstructor');
    Route::post('/update', 'InstructorSettingController@update')->name('instructor.update')->middleware('RoutePermissionCheck:instructor.edit');
    Route::post('/destroy', 'InstructorSettingController@destroy')->name('instructor.delete')->middleware('RoutePermissionCheck:instructor.delete');
    Route::get('/status/{id}', 'InstructorSettingController@status')->name('instructor.change_status')->middleware('RoutePermissionCheck:instructor.change_status');

    //Email Setting
    Route::get('/editEmailSetting', 'SystemSettingController@editEmailSetting');
    Route::post('/updateEmailSetting', 'SystemSettingController@updateEmailSetting')->name('updateEmailSetting');
    Route::post('/sendTestMail', 'SystemSettingController@sendTestMail')->name('sendTestMail');
    Route::get('/getEmailTemp', 'SystemSettingController@getEmailTemp');
    Route::get('/editEmailTemp/{id}', 'SystemSettingController@editEmailTemp');
    Route::get('/viewEmailTemp/{id}', 'SystemSettingController@viewEmailTemp');
    Route::post('/updateEmailTemp', 'SystemSettingController@updateEmailTemp')->name('updateEmailTemp')->middleware('RoutePermissionCheck:updateEmailTemp');
    Route::post('/footerTemplateUpdate', 'SystemSettingController@footerTemplateUpdate')->name('footerTemplateUpdate')->middleware('RoutePermissionCheck:footerTemplateUpdate');

    //Web Setting
    Route::post('/websiteSetting', 'SystemSettingController@websiteSetting');
    Route::post('/seoSetting', 'SystemSettingController@seoSetting');
    Route::post('/recapchaSetting', 'SystemSettingController@recapchaSetting');
    Route::post('/homeVarriant/{id}', 'SystemSettingController@homeVarriant');
    Route::post('/systemSetting', 'SystemSettingController@systemSetting');
    Route::get('/websiteSetting_view', 'SystemSettingController@websiteSetting_view');
    Route::get('/alltimezones', 'SystemSettingController@alltimezones');

    //Currency Setting
    Route::get('/allCurrency', 'SystemSettingController@allCurrency');
    Route::get('/currencyStatus/{id}', 'SystemSettingController@currencyStatus');
    Route::get('/currency_edit/{id}', 'SystemSettingController@currency_edit');
    Route::post('/currency_update', 'SystemSettingController@currency_update');
    Route::post('/currency_add', 'SystemSettingController@currency_add');


    Route::prefix('user')->group(function () {
        //message Area
        Route::get('api', 'SystemSettingController@allApi')->name('api.setting')->middleware('RoutePermissionCheck:api.setting');
        Route::post('save/api', 'SystemSettingController@saveApi')->name('save.api.setting')->middleware('RoutePermissionCheck:api.setting');

        Route::get('/hr/departments', 'DepartmentController@index')->name('hr.department.index');
        Route::post('/hr/departments/store', 'DepartmentController@store')->name('hr.department.store');
        Route::post('/hr/departments/update', 'DepartmentController@update')->name('hr.department.update');
        Route::post('/hr/departments/delete', 'DepartmentController@delete')->name('hr.department.delete');

        Route::get('settings', 'StaffController@settings')->name('staffs.settings');
        Route::post('settings', 'StaffController@settingsPost')->name('staffs.settings');
        Route::resource('staffs', 'StaffController')->except('destroy')->middleware('RoutePermissionCheck:staffs.index');
        Route::post('/staff-document/store', 'StaffController@document_store')->name('staff_document.store');
        Route::get('/staff-document/destroy/{id}', 'StaffController@document_destroy')->name('staff_document.destroy');
        Route::get('/profile-view', 'StaffController@profile_view')->name('profile_view');
        Route::post('/profile-edit', 'StaffController@profile_edit')->name('profile_edit_modal');
        Route::post('/profile-update/{id}', 'StaffController@profile_update')->name('profile.update');


        Route::post('/staff-status-update', 'StaffController@status_update')->name('staffs.update_active_status');
        Route::get('/staff/view/{id}', 'StaffController@show')->name('staffs.view');
        Route::get('/staff/report-print/{id}', 'StaffController@report_print')->name('staffs.report_print');
        Route::get('/staff/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy')->middleware('RoutePermissionCheck:staffs.destroy');
        Route::get('/staff/active/{id}', 'StaffController@active')->name('staffs.active');
        Route::get('/staff/inactive/{id}', 'StaffController@inactive')->name('staffs.inactive');
        Route::post('/staff/inactive-update/{id}', 'StaffController@inactiveUpdate')->name('staffs.inactive.update');
        Route::get('/staff/document-upload', 'StaffController@documentUpload')->name('staffs.document.upload');
        Route::post('/staff/document-store', 'StaffController@documentUploadStore')->name('staffs.document.store');
        Route::get('/staff/document-remove/{id}', 'StaffController@documentRemove')->name('staffs.document.remove');
        Route::get('/staff/resume/{id?}', 'StaffController@staffResume')->name('staffs.resume');

        Route::get('/staff/csv-upload-page', 'StaffController@csv_upload')->name('staffs.csv_upload');
        Route::post('/staff/csv-upload-store', 'StaffController@csv_upload_store')->name('staffs.csv_upload_store');
    });

});


Route::group(['prefix' => 'websitesetting'], function () {
    Route::get('/blog_details/{id}', 'SystemSettingController@blog_detail');
    Route::get('/nextBlog/{id}', 'SystemSettingController@nextBlog');
    Route::get('/previousBlog/{id}', 'SystemSettingController@previousBlog');
    Route::get('/viewBlog/{id}', 'SystemSettingController@viewBlog');

});

