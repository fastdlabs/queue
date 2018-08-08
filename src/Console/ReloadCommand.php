<?php
namespace FastD\Queue\Console;

use Wangjian\Queue\Console\ReloadCommand as BaseReloadCommand;
use Symfony\Component\Console\Input\InputArgument;

class ReloadCommand extends BaseReloadCommand
{
    protected function configure()
    {
        $this->setName('queue:reload')
            ->setDescription('restart the queue consumer worker')
            ->addArgument('name', InputArgument::REQUIRED, 'the worker name', app()->getName());
    }
}