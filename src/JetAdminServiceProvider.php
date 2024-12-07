<?php

namespace AliQasemzadeh\JetAdmin;

use Illuminate\Support\ServiceProvider;
class JetAdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/jetadmin.php' => config_path('jetadmin.php'),
        ], 'jetadmin-config');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/jetadmin'),
        ], 'jetadmin-lang');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'jetadmin');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/jetadmin.php', 'jetadmin'
        );
    }
}
