<?php

namespace Zilf\System\Bus;

use Zilf\Bus\Dispatcher;
use Zilf\System\Zilf;

trait DispatchesJobs
{
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param  mixed $job
     * @return mixed
     */
    protected function dispatch($job)
    {
        return Zilf::$app->get(Dispatcher::class)->dispatch($job);
    }

    /**
     * Dispatch a job to its appropriate handler in the current process.
     *
     * @param  mixed $job
     * @return mixed
     */
    public function dispatchNow($job)
    {
        return Zilf::$app->get(Dispatcher::class)->dispatchNow($job);
    }
}
