<?php

namespace Zilf\Queue;

use Zilf\Db\Connection;
use Zilf\Support\Carbon;

use Zilf\Queue\Jobs\DatabaseJob;
use Zilf\Queue\Jobs\DatabaseJobRecord;

class DatabaseQueue extends Queue
{
    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\Connection
     */
    protected $database;

    /**
     * The database table that holds the jobs.
     *
     * @var string
     */
    protected $table;

    /**
     * The name of the default queue.
     *
     * @var string
     */
    protected $default;

    /**
     * The expiration time of a job.
     *
     * @var int|null
     */
    protected $retryAfter = 60;

    /**
     * Create a new database queue instance.
     *
     * @param  \Zilf\Db\Connection $database
     * @param  string              $table
     * @param  string              $default
     * @param  int                 $retryAfter
     * @return void
     */
    public function __construct(Connection $database, $table, $default = 'default', $retryAfter = 60)
    {
        $this->table = $table;
        $this->default = $default;
        $this->database = $database;
        $this->retryAfter = $retryAfter;
    }

    /**
     * Get the size of the queue.
     *
     * @param  string $queue
     * @return int
     */
    public function size($queue = null)
    {
        return $this->database->table($this->table)
            ->where('queue', $this->getQueue($queue))
            ->count();
    }

    /**
     * Push a new job onto the queue.
     *
     * @param  string $job
     * @param  mixed  $data
     * @param  string $queue
     * @return mixed
     */
    public function push($job, $data = '', $queue = null)
    {
        return $this->pushToDatabase($queue, $this->createPayload($job, $data));
    }

    /**
     * Push a raw payload onto the queue.
     *
     * @param  string $payload
     * @param  string $queue
     * @param  array  $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = [])
    {
        return $this->pushToDatabase($queue, $payload);
    }

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param  \DateTimeInterface|\DateInterval|int $delay
     * @param  string                               $job
     * @param  mixed                                $data
     * @param  string                               $queue
     * @return void
     */
    public function later($delay, $job, $data = '', $queue = null)
    {
        return $this->pushToDatabase($queue, $this->createPayload($job, $data), $delay);
    }

    /**
     * Push an array of jobs onto the queue.
     *
     * @param  array  $jobs
     * @param  mixed  $data
     * @param  string $queue
     * @return mixed
     */
    public function bulk($jobs, $data = '', $queue = null)
    {
        $queue = $this->getQueue($queue);

        $availableAt = $this->availableAt();

        return $this->database->table($this->table)->insert(
            collect((array)$jobs)->map(
                function ($job) use ($queue, $data, $availableAt) {
                    return $this->buildDatabaseRecord($queue, $this->createPayload($job, $data), $availableAt);
                }
            )->all()
        );
    }

    /**
     * Release a reserved job back onto the queue.
     *
     * @param  string                                   $queue
     * @param  \Illuminate\Queue\Jobs\DatabaseJobRecord $job
     * @param  int                                      $delay
     * @return mixed
     */
    public function release($queue, $job, $delay)
    {
        return $this->pushToDatabase($queue, $job->payload, $delay, $job->attempts);
    }

    /**
     * Push a raw payload to the database with a given delay.
     *
     * @param  string|null                          $queue
     * @param  string                               $payload
     * @param  \DateTimeInterface|\DateInterval|int $delay
     * @param  int                                  $attempts
     * @return mixed
     */
    protected function pushToDatabase($queue, $payload, $delay = 0, $attempts = 0)
    {
        return $this->database->createCommand()->insert(
            $this->table,
            $this->buildDatabaseRecord(
                $this->getQueue($queue), $payload, $this->availableAt($delay), $attempts
            )
        )->execute();
    }

    /**
     * Create an array to insert for the given job.
     *
     * @param  string|null $queue
     * @param  string      $payload
     * @param  int         $availableAt
     * @param  int         $attempts
     * @return array
     */
    protected function buildDatabaseRecord($queue, $payload, $availableAt, $attempts = 0)
    {
        return [
            'queue' => $queue,
            'attempts' => $attempts,
            'reserved_at' => null,
            'available_at' => $availableAt,
            'created_at' => $this->currentTime(),
            'payload' => $payload,
        ];
    }

    /**
     * Pop the next job off of the queue.
     *
     * @param  string $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     * @throws \Exception|\Throwable
     */
    public function pop($queue = null)
    {
        $queue = $this->getQueue($queue);

        return $this->database->transaction(
            function () use ($queue) {
                if ($job = $this->getNextAvailableJob($queue)) {
                    return $this->marshalJob($queue, $job);
                }

                return null;
            }
        );
    }

    /**
     * Get the next available job for the queue.
     *
     * @param  string|null $queue
     * @return \Illuminate\Queue\Jobs\DatabaseJobRecord|null
     */
    protected function getNextAvailableJob($queue)
    {
        $expiration = Carbon::now()->subSeconds($this->retryAfter)->getTimestamp();
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE queue =\'' . $this->getQueue($queue) . '\' 
                AND (
                        (reserved_at is NULL AND available_at <=' . $this->currentTime() . ')
                        OR 
                        (reserved_at <= ' . $expiration . ')
                    ) 
                order by id asc limit 1 ';

        $job = $this->database->createCommand($sql)->queryOne();

        return $job ? new DatabaseJobRecord((object)$job) : null;
    }

    /**
     * Modify the query to check for available jobs.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return void
     */
    protected function isAvailable($query)
    {
        $query->where(
            function ($query) {
                $query->whereNull('reserved_at')
                    ->where('available_at', '<=', $this->currentTime());
            }
        );
    }

    /**
     * Modify the query to check for jobs that are reserved but have expired.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return void
     */
    protected function isReservedButExpired($query)
    {
        $expiration = Carbon::now()->subSeconds($this->retryAfter)->getTimestamp();

        $query->orWhere(
            function ($query) use ($expiration) {
                $query->where('reserved_at', '<=', $expiration);
            }
        );
    }

    /**
     * Marshal the reserved job into a DatabaseJob instance.
     *
     * @param  string                                   $queue
     * @param  \Illuminate\Queue\Jobs\DatabaseJobRecord $job
     * @return \Illuminate\Queue\Jobs\DatabaseJob
     */
    protected function marshalJob($queue, $job)
    {
        $job = $this->markJobAsReserved($job);

        return new DatabaseJob(
            $this, $job, $this->connectionName, $queue
        );
    }

    /**
     * Mark the given job ID as reserved.
     *
     * @param  \Illuminate\Queue\Jobs\DatabaseJobRecord $job
     * @return \Illuminate\Queue\Jobs\DatabaseJobRecord
     */
    protected function markJobAsReserved($job)
    {
        $this->database->createCommand()->update(
            $this->table, [
            'reserved_at' => $job->touch(),
            'attempts' => $job->increment(),
            ], [
            'id' => $job->id
            ]
        )->execute();

        return $job;
    }

    /**
     * Delete a reserved job from the queue.
     *
     * @param  string $queue
     * @param  string $id
     * @return void
     * @throws \Exception|\Throwable
     */
    public function deleteReserved($queue, $id)
    {
        $this->database->transaction(
            function () use ($id) {
                $this->database->createCommand()->delete($this->table, ['id' => $id])->execute();
            }
        );
    }

    /**
     * Get the queue or return the default.
     *
     * @param  string|null $queue
     * @return string
     */
    public function getQueue($queue)
    {
        return $queue ?: $this->default;
    }

    /**
     * Get the underlying database instance.
     *
     * @return \Illuminate\Database\Connection
     */
    public function getDatabase()
    {
        return $this->database;
    }
}
