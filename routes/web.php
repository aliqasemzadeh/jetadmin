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

            Volt::route('settings/profile', 'user.settings.profile')->name('user.settings.profile');
            Volt::route('settings/password', 'user.settings.password')->name('user.settings.password');
            Volt::route('settings/appearance', 'user.settings.appearance')->name('user.settings.appearance');
            Route::get('settings/session', App\Livewire\User\Settings\Session\Index::class)->name('user.settings.session');
        });

        Route::prefix(config('jetadmin.route-prefix.administrator'))->group(function () {
            Route::get('/dashboard/index', App\Livewire\Administrator\Dashboard\Index::class)->name('administrator.dashboard.index');

            Route::get('/user-management/user/index', App\Livewire\Administrator\UserManagement\User\Index::class)->name('administrator.user-management.user.index');
            Route::get('/user-management/role/index', App\Livewire\Administrator\UserManagement\Role\Index::class)->name('administrator.user-management.role.index');
            Route::get('/user-management/permission/index', App\Livewire\Administrator\UserManagement\Permission\Index::class)->name('administrator.user-management.permission.index');

            Route::get('/content-management/article/index', App\Livewire\Administrator\ContentManagement\Article\Index::class)->name('administrator.content-management.article.index');
            Route::get('/content-management/faq/index', App\Livewire\Administrator\ContentManagement\Faq\Index::class)->name('administrator.content-management.faq.index');

            Route::get('/support-management/ticket/index', App\Livewire\Administrator\SupportManagement\Ticket\Index::class)->name('administrator.support-management.ticket.index');
            Route::get('/support-management/ticket/view/{id}', App\Livewire\Administrator\SupportManagement\Ticket\View::class)->name('administrator.support-management.ticket.view');

            Route::get('/setting-management/category/index', App\Livewire\Administrator\SettingManagement\Category\Index::class)->name('administrator.setting-management.category.index');
            Route::get('/setting-management/option/index', App\Livewire\Administrator\SettingManagement\Option\Index::class)->name('administrator.setting-management.option.index');
        });


    });

    require __DIR__.'/auth.php';

});
