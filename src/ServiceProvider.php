<?php

namespace RusBios\LUtils;

use RusBios\LUtils\Middleware\Admin;
use RusBios\LUtils\Models\Config;
use RusBios\LUtils\Services\Menu;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        Config::loadAll([env('RB_CONFIG_PATH')]);

        $this->loadMigrationsFrom([
            __DIR__ . '/migrations/2019_12_03_000000_create_config_table.php',
            __DIR__ . '/migrations/2020_03_01_000000_updated_users_table.php',
            __DIR__ . '/migrations/2020_02_16_152122_create_articles_table.php'
        ]);

        $this->loadViewsFrom( __DIR__ . '/views', 'rb_admin');
        $this->loadRoutesFrom(__DIR__ . '/router.php');

        $this->app['router']->aliasMiddleware('rb_admin', Admin::class);

        $this->app->singleton(Menu::class);
    }
}
