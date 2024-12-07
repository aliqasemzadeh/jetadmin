<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => config('jetadmin.url.admin_prefix')], function () {
    Route::get('/', AliQasemzadeh\JetAdmin\Livewire\Admin\Dashboard::class)->name('jetadmin.admin.dashboard.index');
});
