<?php
namespace Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wangjian\Queue\Console\ReloadCommand as BaseReloadCommand;

class ReloadCommand extends BaseReloadCommand
{
    protected function configure()
    {
        $this->setName('queue:reload')
            ->setDescription('restart the queue consumer worker');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $input->setArgument('name', app()->getName());
        parent::execute($input, $output);
    }
}