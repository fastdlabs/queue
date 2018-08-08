<?php
namespace FastD\Queue\Console;

use FastD\Queue\Traits\LoadConfig;
use Wangjian\Queue\Console\StartCommand as BaseStartCommand;
use Symfony\Component\Console\Input\InputArgument;

class StartCommand extends BaseStartCommand
{
    use LoadConfig;

    protected function configure()
    {
        $this->setName('queue:start')
            ->setDescription('start the queue consumer worker')
            ->addArgument('name', InputArgument::OPTIONAL, 'the worker name', app()->getName());
    }
}