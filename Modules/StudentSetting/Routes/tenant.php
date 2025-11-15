<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin/student', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/allStudent', 'StudentSettingController@index')->name('student.student_list')->middleware('RoutePermissionCheck:student.student_list');
    Route::get('/store', 'StudentSettingController@create')->name('student.store')->middleware('RoutePermissionCheck:student.store');
    Route::post('/store', 'StudentSettingController@store')->middleware('RoutePermissionCheck:student.store');
    Route::get('/show/{id}', 'StudentSettingController@show')->name('student.show')->middleware('RoutePermissionCheck:student.student_list');
    Route::get('/edit/{id}', 'StudentSettingController@edit')->name('student.edit')->middleware('RoutePermissionCheck:student.edit');
    Route::post('/update', 'StudentSettingController@update')->name('student.update')->middleware('RoutePermissionCheck:student.edit');
    Route::post('/destroy', 'StudentSettingController@destroy')->name('student.delete')->middleware('RoutePermissionCheck:student.delete');


    Route::get('/all/student-data', 'StudentSettingController@getAllStudentData')->name('student.getAllStudentData')->middleware('RoutePermissionCheck:student.student_list');

    Route::get('assign-courses/{id}', 'StudentSettingController@studentAssignedCourses')->name('student.courses')->middleware('RoutePermissionCheck:student.courses');


    Route::get('field', 'StudentSettingController@field')->name('student.student_field')->middleware('RoutePermissionCheck:student.student_field');
    Route::post('field/Store', 'StudentSettingController@fieldstore')->name('student.student_field_store')->middleware('RoutePermissionCheck:student.student_field');


    Route::get('/enroll-new', 'StudentSettingController@newEnroll')->name('student.new_enroll')->middleware('RoutePermissionCheck:student.new_enroll');
    Route::post('/enroll-new', 'StudentSettingController@newEnrollSubmit')->name('student.new_enroll_submit')->middleware('RoutePermissionCheck:student.new_enroll');


    Route::get('/login-activity/{user_id}', 'StudentSettingController@studentLoginActivity')->name('student.loginActivity')->middleware('RoutePermissionCheck:student.loginActivity');




    Route::get('student-excel-download', 'StudentImportController@export')->name('student_excel_download');
    Route::get('country_list_download', 'StudentImportController@country_list_export')->name('country_list_download');

    Route::get('student-import', 'StudentImportController@index')->name('student_import')->middleware('RoutePermissionCheck:student_import');
    Route::post('student-import', 'StudentImportController@store')->name('student_import_save')->middleware('RoutePermissionCheck:student_import');

    Route::get('regular_student-import', 'StudentImportController@regular')->name('regular_student_import')->middleware('RoutePermissionCheck:regular_student_import');
    Route::post('regular_student-import', 'StudentImportController@regularStore')->name('regular_student_import_save')->middleware('RoutePermissionCheck:regular_student_import');
    Route::get('regular_student-excel-download', 'StudentImportController@regularStudentexport')->name('regular_student_excel_download')->middleware('RoutePermissionCheck:regular_student_import');
    Route::get('skillgroup/{id}', 'StudentSettingController@Skill_group')->name('student.skillgroup');


    Route::get('/student/institutes', 'StudentInstituteController@index')->name('student.institute.index')->middleware('RoutePermissionCheck:student.institute.index');
    Route::post('/student/institutes', 'StudentInstituteController@store')->name('student.institute.store')->middleware('RoutePermissionCheck:student.institute.index');
    Route::get('/student/edit/{id}', 'StudentInstituteController@edit')->name('student.institute.edit')->middleware('RoutePermissionCheck:student.institute.index');
    Route::post('/student/edit/{id}', 'StudentInstituteController@update')->name('student.institute.update')->middleware('RoutePermissionCheck:student.institute.index');
    Route::get('/student/delete/{id}', 'StudentInstituteController@delete')->name('student.institute.delete')->middleware('RoutePermissionCheck:student.institute.index');


});


Route::group(['prefix' => 'student/dashboard', 'middleware' => ['auth', 'student']], function () {


    Route::get('/bookmarkSave/{id}', 'BookmarkController@bookmarkSave')->name('bookmarkSave');
    Route::get('/bookmarksDelete/{id}', 'BookmarkController@bookmarksDelete');
    Route::get('/bookmarks/show/{id}', 'BookmarkController@show');

});
