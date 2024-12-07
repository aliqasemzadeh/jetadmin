<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('jetadmin.url.admin_prefix')], function () {
    Route::get('/', 'JetadminController@index')->name('jetadmin.admin.dashboard.index');
});
