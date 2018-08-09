<?php
namespace FastD\Queue\Traits;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait LoadConfig
{
    protected function loadConfig(InputInterface $input, OutputInterface $output)
    {
        //刷新消息队列配置
        config()->merge([
            'queue' => config()->load(app()->getPath() . '/config/queue.php')
        ]);
        $connection = $connection = config()->get('queue.connection', 'default');

        $data['QUEUE_ADAPTER'] = config()->get("queue.connections.$connection.driver", 'redis');
        switch ($data['QUEUE_ADAPTER']) {
            case 'redis':
                $data['QUEUE_REDIS_SCHEMA'] = config()->get("queue.connections.$connection.schema", 'tcp');
                $data['QUEUE_REDIS_HOST'] = config()->get("queue.connections.$connection.host", '127.0.0.1');
                $data['QUEUE_REDIS_PORT'] = config()->get("queue.connections.$connection.port", 6379);
                $data['QUEUE_REDIS_DATABASE'] = config()->get("queue.connections.$connection.database", 0);
                $data['QUEUE_REDIS_PASSWORD'] = config()->get("queue.connections.$connection.password", null);
                $data['QUEUE_REDIS_PREFIX'] = config()->get("queue.connections.$connection.prefix", '');
                break;
            case 'mysql':
                $data['QUEUE_MYSQL_HOST'] = config()->get("queue.connections.$connection.host", '127.0.0.1');
                $data['QUEUE_MYSQL_PORT'] = config()->get("queue.connections.$connection.port", 3306);
                $data['QUEUE_MYSQL_DATABASE'] = config()->get("queue.connections.$connection.database", 'queue');
                $data['QUEUE_MYSQL_USERNAME'] = config()->get("queue.connections.$connection.user", 'root');
                $data['QUEUE_MYSQL_PASSWORD'] = config()->get("queue.connections.$connection.pass", 'root');
                $data['QUEUE_MYSQL_TABLENAME'] = config()->get("queue.connections.$connection.table", 'queue');
                break;
        }

        $this->configVariables = array_merge($data, [
            'QUEUE_WORK_QUEUES' => config()->get("queue.connections.$connection.work_queues", 'default'),
            'QUEUE_WORKERS' => config()->get("queue.connections.$connection.workers", 4),
            'QUEUE_SLEEP_INTERVAL' => config()->get("queue.connections.$connection.sleep_interval", 5),
            'QUEUE_MAX_JOBS' => config()->get("queue.connections.$connection.max_jobs", 10000),
            'QUEUE_MAX_ERROR_TIMES' => config()->get("queue.connections.$connection.max_error_times", 10),
            'QUEUE_ERROR_INTERVAL' => config()->get("queue.connections.$connection.error_interval", 1),
        ]);
    }
}