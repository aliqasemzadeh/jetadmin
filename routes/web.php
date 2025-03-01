<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::group([
    'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function (){

    Route::middleware(['auth'])->group(function () {

        Route::get('/', App\Livewire\User\Dashboard\Index::class)->name('dashboard');

        Route::prefix(config('jetadmin.route-prefix.user'))->group(function () {
            Route::get('/dashboard/index', App\Livewire\User\Dashboard\Index::class)->name('user.dashboard.index');


            Route::redirect('settings', 'settings/profile');
            Route::redirect('settings', 'settings/profile');

            Volt::route('settings/profile', 'settings.profile')->name('user.settings.profile');
            Volt::route('settings/password', 'settings.password')->name('user.settings.password');
            Volt::route('settings/appearance', 'settings.appearance')->name('user.settings.appearance');
        });

        Route::prefix(config('jetadmin.route-prefix.administrator'))->group(function () {
            Route::get('/dashboard/index', App\Livewire\Administrator\Dashboard\Index::class)->name('administrator.dashboard.index');
            Route::get('/user-management/user/index', App\Livewire\Administrator\UserManagement\User\Index::class)->name('administrator.user-management.user.index');
            Route::get('/user-management/role/index', App\Livewire\Administrator\UserManagement\Role\Index::class)->name('administrator.user-management.role.index');
            Route::get('/user-management/permission/index', App\Livewire\Administrator\UserManagement\Permission\Index::class)->name('administrator.user-management.permission.index');
        });


    });

    require __DIR__.'/auth.php';

});
