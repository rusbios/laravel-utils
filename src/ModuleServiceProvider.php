<?php

namespace RusBios\LUtils;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use RusBios\LUtils\Commands\ModulesRunCommand;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Config::set('head', require __DIR__ . '/config/head.php');

        $this->loadMigrationsFrom([
            __DIR__ . '/migrations/2019_12_03_000000_create_config_table.php',
            __DIR__ . '/migrations/2020_05_01_000000_create_run_command_table.php',
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                ModulesRunCommand::class,
            ]);
        }
    }
}
