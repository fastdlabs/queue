<?php
namespace FastD\Queue\Console;

use FastD\Queue\Traits\LoadConfig;
use Wangjian\Queue\Console\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    use LoadConfig;

    protected function configure()
    {
        $this->setName('queue:migrate')
            ->setDescription('migrate the queue database');
    }
}