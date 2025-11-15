<?php

use Illuminate\Support\Facades\Route;

Route::prefix('sidebar-manager')->middleware(['auth', 'RoutePermissionCheck:sidebar-manager.index'])->group(function () {
    Route::get('/', 'SidebarManagerController@index')->name('sidebar-manager.index');
    //section store
    Route::post('/section/store', 'SidebarManagerController@sectionStore')->name('sidebar-manager.section.store')->middleware('demo');
    Route::post('/section/menu-store', 'SidebarManagerController@menuStore')->name('sidebar-manager.menu-store')->middleware('demo');
    Route::post('/section/menu-update', 'SidebarManagerController@menuUpdate')->name('sidebar-manager.menu-update')->middleware('demo');
    Route::post('/section/menu-edit', 'SidebarManagerController@menuEdit')->name('sidebar-manager.menu-edit');
    Route::post('/section-edit', 'SidebarManagerController@sectionEdit')->name('sidebar-manager.section-edit');
    Route::post('/section/add-to-menu', 'SidebarManagerController@addToMenu')->name('sidebar-manager.add-to-menu')->middleware('demo');
    Route::post('/section/sort-section', 'SidebarManagerController@sortSection')->name('sidebar-manager.sort-section')->middleware('demo');
    Route::post('/section/delete-section', 'SidebarManagerController@deleteSection')->name('sidebar-manager.delete-section')->middleware('demo');
    Route::post('/section/remove-menu', 'SidebarManagerController@removeMenu')->name('sidebar-manager.menu-remove')->middleware('demo');
    Route::post('/section/reset-own-menu', 'SidebarManagerController@resetMenu')->name('sidebar-manager.reset-own-menu')->middleware('demo');

    Route::get('/permission-cache-clear', 'SidebarManagerController@resetPermissionCache')->name('sidebar-manager.resetPermissionCache');
    Route::get('/menu-edit-form/{id}', 'SidebarManagerController@menuEditForm')->name('sidebar-manager.menu-edit-form');
    Route::get('/section-edit-form/{id}', 'SidebarManagerController@sectionEditForm')->name('sidebar-manager.section-edit-form');
});
