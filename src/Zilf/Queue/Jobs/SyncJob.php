<?php

namespace Zilf\Queue\Jobs;

class SyncJob extends Job
{
    /**
     * The class name of the job.
     *
     * @var string
     */
    protected $job;

    /**
     * The queue message data.
     *
     * @var string
     */
    protected $payload;

    /**
     * Create a new job instance.
     *
     * @param  string $payload
     * @param  string $connectionName
     * @param  string $queue
     * @return void
     */
    public function __construct($payload, $connectionName, $queue)
    {
        $this->queue = $queue;
        $this->payload = $payload;
        $this->connectionName = $connectionName;
    }

    /**
     * Release the job back into the queue.
     *
     * @param  int $delay
     * @return void
     */
    public function release($delay = 0)
    {
        parent::release($delay);
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return 1;
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        return '';
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->payload;
    }

    /**
     * Get the name of the queue the job belongs to.
     *
     * @return string
     */
    public function getQueue()
    {
        return 'sync';
    }
}
