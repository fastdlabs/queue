<?php
namespace FastD\Queue\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wangjian\Queue\Console\StopCommand as BaseStopCommand;

class StopCommand extends BaseStopCommand
{
    protected function configure()
    {
        $this->setName('queue:stop')
            ->setDescription('stop the queue consumer worker');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $input->setArgument('name', app()->getName());
        parent::execute($input, $output);
    }
}