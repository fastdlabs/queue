<?php
namespace FastD\Queue\Traits;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait LoadConfig
{
    protected function loadConfig(InputInterface $input, OutputInterface $output)
    {
        $configs = config()->get('queue');
        $driverConfigs = $configs[config()->get('queue.connection')];

        $data['QUEUE_ADAPTER'] = $driverConfigs['driver'];
        switch ($data['driver']) {
            case 'redis':
                $data['QUEUE_REDIS_SCHEMA'] = $driverConfigs['schema'];
                $data['QUEUE_REDIS_HOST'] = $driverConfigs['host'];
                $data['QUEUE_REDIS_PORT'] = $driverConfigs['port'];
                $data['QUEUE_REDIS_DATABASE'] = $driverConfigs['database'];
                $data['QUEUE_REDIS_PASSWORD'] = $driverConfigs['password'];
                $data['QUEUE_REDIS_PREFIX'] = $driverConfigs['prefix'];
                break;
            case 'mysql':
                $data['QUEUE_MYSQL_HOST'] = $driverConfigs['host'];
                $data['QUEUE_MYSQL_PORT'] = $driverConfigs['port'];
                $data['QUEUE_MYSQL_DATABASE'] = $driverConfigs['database'];
                $data['QUEUE_MYSQL_USERNAME'] = $driverConfigs['user'];
                $data['QUEUE_MYSQL_PASSWORD'] = $driverConfigs['pass'];
                $data['QUEUE_MYSQL_TABLENAME'] = $driverConfigs['table'];
                break;
        }

        $this->configVariables = array_merge($data, [
            'QUEUE_WORK_QUEUES' => $configs['work_queues'],
            'QUEUE_WORKERS' => $configs['workers'],
            'QUEUE_SLEEP_INTERVAL' => $configs['sleep_interval'],
            'QUEUE_MAX_JOBS' => $configs['max_jobs'],
            'QUEUE_MAX_ERROR_TIMES' => $configs['max_error_times'],
            'QUEUE_ERROR_INTERVAL' => $configs['error_interval'],
        ]);
    }
}