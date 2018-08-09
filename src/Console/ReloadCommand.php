<?php
namespace FastD\Queue\Console;

use Wangjian\Queue\Console\ReloadCommand as BaseReloadCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReloadCommand extends BaseReloadCommand
{
    protected function configure()
    {
        $this->setName('queue:reload')
            ->setDescription('restart the queue consumer worker');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        //check whether the worker is running
        $workerName = app()->getName();
        exec("ps -ef | awk '$8 == \"queue:$workerName:master\" {print $2}'", $out, $return);
        if(empty($out)) {
            $output->writeln('<info>the worker is not running...</info>');
            exit(1);
        }

        exec("ps -ef | awk '$8 == \"queue:$workerName:master\" {print $2}' | xargs kill -usr1", $out, $return);
    }
}