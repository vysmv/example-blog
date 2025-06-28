<?php

namespace Vysmv\EasyStart\Docker\Console\Commands;

use Illuminate\Console\Command;

class InstallDockerCommand extends Command
{
    protected $signature = 'easy-start:install-docker';

    protected $description = 'This command installs the docker';

    public function handle()
    {
        $this->info('🔧 Installing docker...');

        $this->addSectionSystemUserInEnv();

        $this->call('vendor:publish', ['--tag' => 'easy-start-docker']);

        $this->makeEntrypointFileExecutable();

        $this->call('vendor:publish', ['--tag' => 'easy-start-docker-compose-yml']);

        $this->call('vendor:publish', ['--tag' => 'easy-start-docker-makefile']);

        $this->updateSectionDBInEnv();

        $this->updateSectionAWSInEnv();

        $this->updateSectionREDISInEnv();

        $this->info('📦 Install the package league/flysystem-aws-s3-v3...');
        shell_exec('composer require league/flysystem-aws-s3-v3');
        $this->info('✅ The package "league/flysystem-aws-s3-v3" is installed!');

        $this->info('✅ Docker is installed!');
    }

    private function addSectionSystemUserInEnv(): void
    {
        if (PHP_OS_FAMILY === 'Linux') {
            $id = getmyuid();
            $name = get_current_user();
        } elseif (PHP_OS_FAMILY === 'Windows') {
            $id = 0;
            $name = 'root';
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            //
        }

        $env = file_get_contents(dirname(__DIR__, 2) . '/env/.env');
        $env = str_replace('id', $id, $env);
        $env = str_replace('name', $name, $env);
        file_put_contents(base_path('/.env'), $env, FILE_APPEND);
    }

    private function makeEntrypointFileExecutable(): void
    {
        $file = base_path('/docker/php-fpm/entrypoint.bash');
        if (file_exists($file)) {
            chmod($file, 0755);
        }
    }

    private function updateSectionDBInEnv(): void
    {
        $filePath = base_path() . '/.env';

        $envContent = file_get_contents($filePath);

        $dbName = config('easy-start.docker.db_name');

         // Удаляем старый блок DB
        $envContent = preg_replace(
            '/DB_CONNECTION=sqlite\n# DB_HOST=127.0.0.1\n# DB_PORT=3306\n# DB_DATABASE=laravel\n# DB_USERNAME=root\n# DB_PASSWORD=\n?/m',
            '',
            $envContent
        );

        // Добавляем новый блок DB в конец
        $newDbBlock = "\nDB_CONNECTION=mysql\nDB_HOST=db\nDB_PORT=3306\nDB_DATABASE={$dbName}\nDB_USERNAME=admin\nDB_PASSWORD=admin\n";

        $envContent = rtrim($envContent) . "\n" . $newDbBlock;

        file_put_contents($filePath, $envContent);
    }

    private function updateSectionAWSInEnv(): void
    {
        $envFile = base_path('/.env');
        // Считываем содержимое файла
        $envContent = file_get_contents($envFile);

        // Удаляем старый блок AWS
        $envContent = preg_replace(
            '/AWS_ACCESS_KEY_ID=.*\nAWS_SECRET_ACCESS_KEY=.*\nAWS_DEFAULT_REGION=us-east-1\nAWS_BUCKET=.*\nAWS_USE_PATH_STYLE_ENDPOINT=false\n?/m',
            '',
            $envContent
        );

        $backetName = config('easy-start.docker.minio_backet_name');
        // Добавляем новый блок в конец
        $newAwsBlock = "\nAWS_ACCESS_KEY_ID=minioadmin\nAWS_SECRET_ACCESS_KEY=minioadmin\nAWS_DEFAULT_REGION=us-east-1\nAWS_BUCKET={$backetName}\nAWS_USE_PATH_STYLE_ENDPOINT=true\nAWS_ENDPOINT=http://minio:9000\n";

        $envContent = rtrim($envContent) . "\n" . $newAwsBlock;

        $envContent = preg_replace('/^FILESYSTEM_DISK=local/m', 'FILESYSTEM_DISK=s3', $envContent);

        file_put_contents($envFile, $envContent);
    }

    private function updateSectionREDISInEnv(): void
    {
        // Считываем содержимое файла
        $envFile = base_path('/.env');
        $envContent = file_get_contents($envFile);

         // Удаляем старый блок Redis
        $envContent = preg_replace(
            '/REDIS_CLIENT=phpredis\nREDIS_HOST=127.0.0.1\nREDIS_PASSWORD=null\nREDIS_PORT=6379\n?/m',
            '',
            $envContent
        );

        // Добавляем новый блок Redis в конец
        $newRedisBlock = "\nREDIS_CLIENT=phpredis\nREDIS_HOST=redis\nREDIS_PASSWORD=\nREDIS_PORT=6379\n";

        $envContent = rtrim($envContent) . "\n" . $newRedisBlock;

        file_put_contents($envFile, $envContent);
    }
}
