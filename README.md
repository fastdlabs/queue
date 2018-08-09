# queue
消息队列

## Installation

```bash
composer require fastd/queue
```

## Usage

### 消息队列配置

将vendor/fastd/queue/config/queue.php复制到config/queue.php，并修改配置

### 加载服务

修改config/app.php

```php
/**
 * Bootstrap service.
 */
'services' => [
    \FastD\ServiceProvider\RouteServiceProvider::class,
    \FastD\ServiceProvider\LoggerServiceProvider::class,
    \FastD\ServiceProvider\DatabaseServiceProvider::class,
    \FastD\ServiceProvider\CacheServiceProvider::class,
    \LinghitExts\AdminAuth\Provider\AdminAuthProvider::class,
    
    //加载消息队列服务
    \FastD\Queue\QueueServiceProvider::class,
],
```

### 实例

```php
<?php
//将ExampleJob加入到消息队列中
queue()->push(new FastD\Queue\Job\ExampleJob(false, false));
```

### 开启消费者进程

```bash
bin/console queue:start &
```

> 注：在使用mysql作为消息队列驱动时，必须先执行bin/console queue:migrate来创建消息队列表

### 关闭消费者进程

```bash
bin/console queue:stop
```

### 重启消费者进程

```bash
bin/console queue:reload
```

> 注：重启消费者进程只会更新消息队列配置，如果修改了源代码，则必须先关闭消费者进程，然后再重新启动

### swoole模式自动启动消息队列

如果是swoole模式运行，那么可以添加一个StartQueueProcess进程，这个进程会监听消费者进程，如果消费者进程终止，会自动启动。

```php
<?php
return [
    'host' => 'http://'.get_local_ip().':9527',
    'class' => \Server\TaskServer::class,
    'options' => [
        'user' => 'nobody',
        'group' => 'nogroup',
        'pid_file' => __DIR__ . '/../runtime/pid/' . app()->getName() . '.pid',
        'log_file' => __DIR__ . '/../runtime/logs/' . app()->getName() . '.pid',
        'log_level' => 5,
        'worker_num' => 10,
        'task_worker_num' => 20,
    ],
    'processes' => [
        //添加StartQueueProcess进程
        \FastD\Queue\Process\StartQueueProcess::class,
    ],
    'listeners' => [
        [
            'class' => \FastD\Servitization\Server\TCPServer::class,
            'host' => 'tcp://'.get_local_ip().':9528',
        ]
    ],
];
```



