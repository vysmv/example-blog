<?php

namespace Vysmv\EasyStart\Core\Console\Commands;

use Illuminate\Console\Command;

class InstallCoreCommand extends Command
{
    /**
     * Имя команды (то, что вводится в терминале)
     */
    protected $signature = 'easy-start:install';

    /**
     * Описание команды
     */
    protected $description = 'Устанавливает и настраивает EasyStart';

    /**
     * Логика команды
     */
    public function handle()
    {
        $this->info('🔧 Установка EasyStart...');

        $this->call('vendor:publish', ['--tag' => 'easy-start-config']);

        $this->removeStandartEditorConfig();
        $this->call('vendor:publish', ['--tag' => 'easy-start-editorconfig']);

        $this->info('✅ Стандартная конфигурация опубликована!');
    }

    private function removeStandartEditorConfig(): void
    {
        if (file_exists(base_path('.editorconfig'))) {
            unlink(base_path('.editorconfig'));
        }
    }
}
