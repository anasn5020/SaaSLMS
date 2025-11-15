<?php

use Illuminate\Support\Facades\Route;

Route::prefix('footer')->as('footerSetting.')->middleware('auth')->group(function () {
    //footer setting
    Route::get('/footer-setting', 'FooterSettingController@index')->name('footer.index')->middleware('RoutePermissionCheck:footerSetting.footer.index');
    Route::post('/footer-setting', 'FooterSettingController@contentUpdate')->name('footer.content-update')->middleware('RoutePermissionCheck:footerSetting.footer.content-update');
    Route::get('/footer-setting/tab/{id}', 'FooterSettingController@tabSelect')->name('footer.content-tabselect')->middleware('RoutePermissionCheck:footerSetting.footer.index');

    Route::post('/footer-widget', 'FooterSettingController@widgetStore')->name('footer.widget-store')->middleware('RoutePermissionCheck:footerSetting.footer.widget-store');
    Route::post('/footer-widget-status', 'FooterSettingController@widgetStatus')->name('footer.widget-status')->middleware('RoutePermissionCheck:footerSetting.footer.widget-status');
    Route::post('/footer-widget-update', 'FooterSettingController@widgetUpdate')->name('footer.widget-update')->middleware('RoutePermissionCheck:footerSetting.footer.widget-update');
    Route::get('/footer-widget-delete/{id}', 'FooterSettingController@destroy')->name('footer.widget-delete')->middleware('RoutePermissionCheck:footerSetting.footer.widget-delete');
});
