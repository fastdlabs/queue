<?php
namespace FastD\Queue\Job;

use Wangjian\Queue\Exception\SkipRetryException;
use Wangjian\Queue\Job\AbstractJob;

class ExampleJob extends AbstractJob
{
    protected $throwException;

    protected $skipRetry;

    public function __construct($throwException, $skipRetry)
    {
        parent::__construct();

        $this->throwException = $throwException;
        $this->skipRetry = $skipRetry;
    }

    public function run()
    {
        if($this->throwException) {
            if($this->skipRetry) {
                throw new SkipRetryException('skip retry exception');
            } else {
                throw new \Exception('other exception');
            }
        } else {
            echo 'example job';
        }
    }
}