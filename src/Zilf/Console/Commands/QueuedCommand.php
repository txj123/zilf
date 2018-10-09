<?php

namespace Zilf\Console\Commands;

use Zilf\Bus\Queueable;

use Zilf\System\Bus\Dispatchable;

class QueuedCommand
{
    use Dispatchable, Queueable;

    /**
     * The data to pass to the Artisan command.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param  array  $data
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Handle the job.
     *
     * @param  $kernel
     * @return void
     */
    public function handle($kernel)
    {
        call_user_func_array([$kernel, 'call'], $this->data);
    }
}
