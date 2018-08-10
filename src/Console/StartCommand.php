<?php
namespace FastD\Queue\Console;

use FastD\Queue\Traits\LoadConfig;
use Wangjian\Queue\Console\StartCommand as BaseStartCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class StartCommand extends BaseStartCommand
{
    use LoadConfig;

    protected function configure()
    {
        $this->setName('queue:start')
            ->setDescription('start the queue consumer worker')
            ->addOption('daemon', 'd', InputOption::VALUE_NONE, 'whether run as a daemon');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        //check whether the worker is already running
        $workerName = app()->getName();
        exec("ps -ef | awk '$8 == \"queue:$workerName:master\" {print $2}'", $out, $return);
        if(!empty($out)) {
            $output->writeln('<info>the worker is already running...</info>');
            exit(1);
        }

        if($input->getOption('daemon')) {
            $this->daemonize();
        }

        $this->doExecute($input, $output, $workerName, null);
    }
}