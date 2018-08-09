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



