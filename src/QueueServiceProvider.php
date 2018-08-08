<?php
namespace FastD\Queue;

use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use FastD\Queue\Console\MigrateCommand;
use FastD\Queue\Console\ReloadCommand;
use FastD\Queue\Console\StartCommand;
use FastD\Queue\Console\StopCommand;
use Predis\Client;
use Wangjian\Queue\RedisQueue;

class QueueServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        config()->merge([
            'queue' => config()->load(app()->getPath() . '/config/queue.php')
        ]);

        $container->add('queue', $this->createQueue());

        $this->registerCommands();
    }

    protected function createQueue()
    {
        $configs = config()->get('queue.connections')[config()->get('queue.connection')];

        switch ($configs['driver']) {
            case 'redis':
                $data = [
                    'schema' => $configs['schema'],
                    'host' => $configs['host'],
                    'port' => $configs['port'],
                    'database' => $configs['database'],
                ];

                if(!empty($configs['password'])) {
                    $data['password'] = $configs['password'];
                }

                return new RedisQueue(new Client($data), $configs['prefix']);
                break;
            case 'mysql':
                $pdo = new \PDO(sprintf(
                    'mysql:host=%s;port=%d;dbname=%s',
                    $configs['host'],
                    $configs['port'],
                    $configs['database']
                ), $configs['user'], $configs['pass']);
                return new \Wangjian\Queue\MysqlQueue($pdo, $configs['table']);
                break;
        }
    }

    protected function registerCommands()
    {
        config()->merge([
            'consoles' => [
                StartCommand::class,
                StopCommand::class,
                MigrateCommand::class,
                ReloadCommand::class,
            ],
        ]);
    }
}