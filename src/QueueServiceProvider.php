<?php
namespace FastD\Queue;

use FastD\Container\Container;
use FastD\Container\ServiceProviderInterface;
use FastD\Queue\Console\MigrateCommand;
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
        $connection = config()->get('queue.connection', 'default');

        switch (config()->get("queue.connections.$connection.driver", 'redis')) {
            case 'redis':
                $data = [
                    'schema' => config()->get("queue.connections.$connection.schema", 'tcp'),
                    'host' => config()->get("queue.connections.$connection.host", '127.0.0.1'),
                    'port' => config()->get("queue.connections.$connection.port", 6379),
                    'database' => config()->get("queue.connections.$connection.database", 0),
                ];

                if(!empty($password = config()->get("queue.connections.$connection.password", null))) {
                    $data['password'] = $password;
                }

                return new RedisQueue(new Client($data), config()->get("queue.connections.$connection.prefix", ''));
                break;
            case 'mysql':
                $pdo = new \PDO(
                    sprintf(
                        'mysql:host=%s;port=%d;dbname=%s',
                        config()->get("queue.connections.$connection.host", '127.0.0.1'),
                        config()->get("queue.connections.$connection.port", 3306),
                        config()->get("queue.connections.$connection.database", 'queue')
                    ),
                    config()->get("queue.connections.$connection.user", 'root'),
                    config()->get("queue.connections.$connection.pass", 'root')
                );
                return new \Wangjian\Queue\MysqlQueue($pdo, config()->get("queue.connections.$connection.table", 'queue'));
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
            ],
        ]);
    }
}