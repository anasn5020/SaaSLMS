<?php


use Illuminate\Support\Facades\Route;

Route::prefix('appearance')->as('appearance.')->middleware('auth')->group(function () {
    Route::get('/', 'AppearanceController@index')->name('index')->middleware('RoutePermissionCheck:appearance.themes.index');

    //themes
    Route::resource('/themes', 'ThemeController')->except('destroy', 'update', 'edit')->middleware('RoutePermissionCheck:appearance.themes.index');
    Route::post('/themes/active', 'ThemeController@active')->name('themes.active')->middleware('RoutePermissionCheck:appearance.themes.index');
    Route::post('/themes/delete', 'ThemeController@destroy')->name('themes.delete')->middleware('RoutePermissionCheck:appearance.themes.index');

    //customize

    Route::get('/demo', 'ThemeController@demo')->name('themes.demo')->middleware('RoutePermissionCheck:appearance.themes.demo');
    Route::post('/demo', 'ThemeController@demoSubmit')->name('themes.demoSubmit')->middleware('RoutePermissionCheck:appearance.themes.demo');

    Route::get('themes-customize/{theme}/copy', 'ThemeCustomizeController@copy')->name('themes-customize.copy')->middleware('RoutePermissionCheck:appearance.themes-customize.index');
    Route::get('themes-customize/{theme}/default', 'ThemeCustomizeController@default')->name('themes-customize.default')->middleware('RoutePermissionCheck:appearance.themes-customize.index');
    Route::resource('themes-customize', 'ThemeCustomizeController')->middleware('RoutePermissionCheck:appearance.themes-customize.index');
    Route::post('themes-customize-setting', 'ThemeCustomizeController@settingUpdate')->name('themes-customize.settingUpdate')->middleware('RoutePermissionCheck:appearance.themes-customize.index');

    Route::resource('themes-font', 'ThemeFontController')->middleware('RoutePermissionCheck:appearance.themes-font.index');

});
