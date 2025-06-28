<?php

namespace Vysmv\EasyStart\Core\Console\Commands;

use Illuminate\Console\Command;

class ShowConfigCommand extends Command
{
    protected $signature = 'easy-start:show-config';

    /**
     * Описание команды
     */
    protected $description = 'Демонстрирует текущие значения файла /config/easy-start.php';

    /**
     * Логика команды
     */
    public function handle()
    {
        dump(config('easy-start'));
    }
}
