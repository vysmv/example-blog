<?php

namespace Vysmv\EasyStart\Docker;

use Illuminate\Support\ServiceProvider;

class EasyStartDockerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/docker' => base_path('/docker'),
        ], 'easy-start-docker');

        $this->publishes([
            __DIR__ . '/docker-compose.yml' => base_path('/docker-compose.yml'),
        ], 'easy-start-docker-compose-yml');

        $this->publishes([
            __DIR__ . '/Makefile' => base_path('/Makefile'),
        ], 'easy-start-docker-makefile');
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Vysmv\EasyStart\Docker\Console\Commands\InstallDockerCommand::class,
            ]);
        }
    }
}
