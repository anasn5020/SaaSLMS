<?php

use Illuminate\Support\Facades\Route;

Route::prefix('role-permission')->middleware(['auth', 'admin'])->group(function () {
    Route::name('permission.')->group(function () {
        Route::resource('roles', 'RoleController')->except('destroy')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::get('roles-student', 'RoleController@studentIndex')->name('student-roles')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::get('roles-staff', 'RoleController@staffIndex')->name('staff-roles')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::resource('permissions', 'PermissionController')->middleware('RoutePermissionCheck:permission.permissions.store');

        Route::get('role/delete/{id}', 'RoleController@destroy')->name('roles.destroy')->middleware('RoutePermissionCheck:permission.permissions.store');

    });
});
