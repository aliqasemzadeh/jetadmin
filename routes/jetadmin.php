<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(), 'middleware' => ['referral']], function() {


    Route::get('/', \AliQasemzadeh\JetAdmin\Http\Livewire\App\Main\Index::class)->name('home');
    Route::get('/article/index', \AliQasemzadeh\JetAdmin\Http\Livewire\App\Article\Index::class)->name('article.index');
    Route::get('/article/view/{article}', \AliQasemzadeh\JetAdmin\Http\Livewire\App\Article\View::class)->name('article.view');

    Route::group(['middleware' => ['auth:sanctum', 'verified']], function() {

        Route::any('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('/user/verify', \AliQasemzadeh\JetAdmin\Http\Livewire\Panel\User\Verify::class)->name('user.verify');
        Route::get('/user/mobile', \AliQasemzadeh\JetAdmin\Http\Livewire\Panel\User\Mobile::class)->name('user.mobile');

        Route::any('/notification/view/{notification}', \AliQasemzadeh\JetAdmin\Http\Livewire\App\Notification\View::class)->name('notification.view');
        Route::any('/faqs/index', \AliQasemzadeh\JetAdmin\Http\Livewire\App\FAQ\Index::class)->name('faqs.index');


        Route::group(['prefix' => config('jetadmin.panel-prefix-url')], function() {
            Route::get('/dashboard/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Panel\Dashboard\Index::class)->name('panel.dashboard.index');

            Route::get('/support/ticket/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Panel\Support\Ticket\Index::class)->name('panel.support.ticket.index');
            Route::get('/support/ticket/create', \AliQasemzadeh\JetAdmin\Http\Livewire\Panel\Support\Ticket\Create::class)->name('panel.support.ticket.create');
            Route::get('/support/ticket/view/{ticket}', \AliQasemzadeh\JetAdmin\Http\Livewire\Panel\Support\Ticket\View::class)->name('panel.support.ticket.view');

        });


        Route::group(['prefix' => config('jetadmin.admin-prefix-url'), 'middleware' => ['auth:sanctum', 'verified', 'admin']], function () {
            Route::get('/dashboard/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard.index');
            Route::get('/user/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Index::class)->name('admin.user.index');
            Route::get('/user/role/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Role\Index::class)->name('admin.user.role.index');
            Route::get('/user/team/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Team\Index::class)->name('admin.user.team.index');
            Route::get('/user/permission/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\User\Permission\Index::class)->name('admin.user.permission.index');

            Route::get('/setting/category/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Setting\Category\Index::class)->name('admin.setting.category.index');
            Route::get('/setting/manage/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Setting\Manage\Index::class)->name('admin.setting.manage.index');

            Route::get('/content/article/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Content\Article\Index::class)->name('admin.content.article.index');
            Route::get('/content/faq/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Content\FAQ\Index::class)->name('admin.content.faq.index');
            Route::get('/content/carousel/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Content\Carousel\Index::class)->name('admin.content.carousel.index');

            Route::get('/support/ticket/index', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Support\Ticket\Index::class)->name('admin.support.ticket.index');
            Route::get('/support/ticket/archive', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Support\Ticket\Archive::class)->name('admin.support.ticket.archive');
            Route::get('/support/ticket/view/{ticket}', \AliQasemzadeh\JetAdmin\Http\Livewire\Admin\Support\Ticket\View::class)->name('admin.support.ticket.view');

        });
    });

});

