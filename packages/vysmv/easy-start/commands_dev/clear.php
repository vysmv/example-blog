<?php

$root_path = __DIR__ . '/../../../..';
chdir($root_path);

if (file_exists($root_path . '/config/easy-start.php')) {
    unlink($root_path . '/config/easy-start.php');
}

if (file_exists($root_path . '/.editorconfig')) {
    unlink($root_path . '/.editorconfig');
}

if (file_exists($root_path . '/docker-compose.yml')) {
    unlink($root_path . '/docker-compose.yml');
}

function treeRmdir($directory)
{
    $dir = opendir($directory);
    while (($file = readdir($dir)) !== false) {
        // Если функция readdir() вернула файл — удаляем его
        if (is_file("$directory/$file")) {
            unlink("$directory/$file");
        }
        // Если функция readdir() вернула каталог
        // и он не равен текущему или родительскому — осуществляем
        // рекурсивный вызов full_del_dir() для этого каталога
        elseif (is_dir("$directory/$file") && $file != "." && $file != "..") {
            treeRmdir("$directory/$file");
        }
    }
    closedir($dir);
    rmdir($directory);
}
treeRmdir($root_path . '/public/assets');
treeRmdir($root_path . '/resources/views/admin');
treeRmdir($root_path . '/app/Http/Controllers/Admin');
treeRmdir($root_path . '/docker');
