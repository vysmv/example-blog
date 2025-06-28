<?php

namespace Vysmv\EasyStart\Core;

use Illuminate\Support\ServiceProvider;

/**
 * Это главный сервис-провайдер пакета, который загружается первым и
 * подключает остальные части пакета посредством $this->app->register.
 */

class EasyStartCoreServiceProvider extends ServiceProvider
{
    /**
     * Выполняется после загрузки всех сервисов, когда Laravel уже готов к работе.
     * Тут удобно загружать миграции, публиковать файлы, привязывать события и т. д.
     */
    public function boot()
    {
        $this->publishesMainConfig();

        $this->publishesEditorConfig();
    }

    /**
     * Выполняется до загрузки всех сервисов и используется для привязки сервисов в контейнере,
     * регистрации конфигов и команд. Отрабатывает раньше чем boot.
     */
    public function register()
    {
        /**
         * Метод mergeConfigFrom() позволяет не перезаписывать конфиг, если он уже опубликован,
         * а дополнять его значениями по умолчанию.
         *
         * Что делает?
         * Загружает дефолтный конфиг из пакета.
         * Если конфиг не опубликован в config/easy-start.php, Laravel будет использовать версию из пакета.
         * Если конфиг опубликован, Laravel объединяет его с дефолтным из пакета.
         * $this->mergeConfigFrom(__DIR__.'/config/easy-start.php', 'easy-start');
         */

        /**
         * Подключает к системе набор artisan команд.
         */
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Vysmv\EasyStart\Core\Console\Commands\InstallCoreCommand::class,
                \Vysmv\EasyStart\Core\Console\Commands\ShowConfigCommand::class,
            ]);
        }

          $this->app->register(\Vysmv\EasyStart\Docker\EasyStartDockerServiceProvider::class);
    }

    private function publishesMainConfig(): void
    {
        $this->publishes([
            __DIR__ . '/config/easy-start.php' => config_path('easy-start.php'),
        ], 'easy-start-config');
    }

    private function publishesEditorConfig(): void
    {
        $this->publishes([
            __DIR__ . '/config/.editorconfig' => base_path('.editorconfig'),
        ], 'easy-start-editorconfig');
    }
}
