<?php

namespace AliQasemzadeh\JetAdmin;

use Illuminate\Support\ServiceProvider;

class JetAdminServiceProvider extends ServiceProvider {
    public function register()
    {
        parent::register();
        $this->mergeConfigFrom(__DIR__.'/../config/jetadmin.php', 'jetadmin');
    }

    public function boot()
    {
        //Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/jetadmin.php');
        $this->publishes([
            __DIR__.'/../config/jetadmin.php' => config_path('jetadmin.php'),
        ], 'jetadmin-config');

        //Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'jetadmin-database');

        //Translation
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'jetadmin');
        $this->publishes([
            __DIR__.'/../resources/lang' => $this->app->langPath('vendor/jetadmin'),
        ], 'jetadmin-translations');

        //Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'jetadmin');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/jetadmin'),
        ], 'jetadmin-views');
    }
}
