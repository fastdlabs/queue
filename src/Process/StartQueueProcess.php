<?php
namespace FastD\Queue\Process;

use FastD\Swoole\Process;
use swoole_process;
use FastD\Queue\Console\StartCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class StartQueueProcess extends Process
{
    public function handle(swoole_process $swoole_process)
    {
        $workerName = app()->getName();
        exec("ps -ef | awk '$8 == \"queue:$workerName:master\" {print $2}'", $out, $return);
        if (empty($out)) {
            $command = new StartCommand();
            $input = new ArrayInput([], $command->getDefinition());
            $output = new ConsoleOutput();
            $command->execute($input, $output);
        }
    }
}