<?php
namespace FastD\Queue\Console;

use Wangjian\Queue\Console\StopCommand as BaseStopCommand;
use Symfony\Component\Console\Input\InputArgument;

class StopCommand extends BaseStopCommand
{
    protected function configure()
    {
        $this->setName('queue:stop')
            ->setDescription('stop the queue consumer worker')
            ->addArgument('name', InputArgument::REQUIRED, 'the worker name', app()->getName());
    }
}