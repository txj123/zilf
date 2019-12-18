<?php

namespace Zilf\System\Bus;

use Illuminate\Contracts\Bus\Dispatcher;
use Zilf\System\Zilf;

trait Dispatchable
{
    /**
     * Dispatch the job with the given arguments.
     *
     * @return \Zilf\System\Bus\PendingDispatch
     */
    public static function dispatch()
    {
        return new PendingDispatch(new static(...func_get_args()));
    }

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @return mixed
     */
    public static function dispatchNow()
    {
        return Zilf::$app[Dispatcher::class]->dispatchNow(new static(...func_get_args()));
    }

    /**
     * Set the jobs that should run if this job is successful.
     *
     * @param  array  $chain
     * @return \Zilf\System\Bus\PendingChain
     */
    public static function withChain($chain)
    {
        return new PendingChain(static::class, $chain);
    }
}
