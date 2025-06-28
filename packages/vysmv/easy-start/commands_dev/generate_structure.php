<?php

//https://stackedit.io/app#
chdir('../');
function printContent($level = 1)
{
    $d = @opendir('.');
    if (!$d) {
        return;
    }

    while (($e = readdir($d)) !== false) {
        if (
            $e === '.' ||
            $e === '..' ||
            $e === 'generate_structure.php' ||
            $e === 'notice' ||
            $e === 'vendor' ||
            $e === 'img' ||
            $e === 'struct_easy-start' ||
            $e === 'adminlte.js' ||
            $e === 'adminlte.css' ||
            $e === 'commands_dev' ||
            $e === 'readme.md'
        ) {
            continue;
        }

        if (!@is_dir($e)) {
            $path = posix_getcwd() . "/$e";
            $parts = explode('vysmv/', $path);
            $path = $parts[1];
            $body = "### Файл:" . $path . PHP_EOL;
            $body .= '' . PHP_EOL;
            $body .= '```php' . PHP_EOL;
            $body .= file_get_contents($e) . PHP_EOL;
            $body .= '```' . PHP_EOL;
            file_put_contents(__DIR__  . '/struct_easy-start', $body . PHP_EOL, FILE_APPEND);
        }

        if (!@is_dir($e) || !chdir($e)) {
            continue;
        }
        printContent($level + 1);
        chdir('..');
    }
    closedir($d);
}

function printTree(&$result, $level = 1)
{
    $d = @opendir('.');
    if (!$d) {
        return;
    }

    while (($e = readdir($d)) !== false) {
        $raw = '';
        if (
            $e === '.' || 
            $e === '..' || 
            $e === 'generate_structure.php' || 
            $e === 'notice' || 
            $e === 'vendor' || 
            $e === 'img' || 
            $e == 'struct_easy-start' || 
            $e === 'readme.md' || 
            $e === 'commands_dev'
        ) {
            continue;
        }

        for ($i = 1; $i < $level; $i++) {
            $raw .= "|  ";
        }
        if (@is_dir($e)) {
            $raw .= "|--$e/";
        } else {
            $raw .= "|--$e";
        }

        $result[] =  $raw;
        if (!@is_dir($e) || !chdir($e)) {
            continue;
        }
        printTree($result, $level + 1);
        chdir('..');
    }
    closedir($d);
}
$result[] = '# Структура пакета Easy Start';
$result[] = '';
$result[] = '```';
$result[] = 'easy-start/';

printTree($result);
$result[] = '```';
$result[] = '## Содержание всех файлов пакета';
$result[] = '';
foreach ($result as $raw) {
    file_put_contents('commands_dev/struct_easy-start', $raw . PHP_EOL, FILE_APPEND);
}

printContent();
