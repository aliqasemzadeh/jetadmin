<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home\Index::class)->name('home');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard/index', \App\Livewire\Admin\User\Index::class)->name('dashboard.index');

    Route::group(['prefix' => config('jetadmin.admin_route_prefix')], function () {
        Route::get('/dashboard/index', \App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard.index');
        Route::get('/user/index', \App\Livewire\Admin\User\Index::class)->name('admin.user.index');
    });


});
