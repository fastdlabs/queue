<?php
namespace FastD\Queue\Console;

use FastD\Queue\Traits\LoadConfig;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wangjian\Queue\Console\StartCommand as BaseStartCommand;

class StartCommand extends BaseStartCommand
{
    use LoadConfig;

    protected function configure()
    {
        $this->setName('queue:start')
            ->setDescription('start the queue consumer worker');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $input->setArgument('name', app()->getName());
        parent::execute($input, $output);
    }
}