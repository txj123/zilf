<?php

namespace Zilf\Queue\Failed;

use Zilf\Db\Connection;
use Zilf\Support\Carbon;
use Illuminate\Database\ConnectionResolverInterface;

class DatabaseFailedJobProvider implements FailedJobProviderInterface
{
    /**
     * The connection resolver implementation.
     *
     * @var \Illuminate\Database\ConnectionResolverInterface
     */
    protected $resolver;

    /**
     * The database connection name.
     *
     * @var string
     */
    protected $database;

    /**
     * The database table.
     *
     * @var string
     */
    protected $table;

    /**
     * Create a new database failed job provider.
     *
     * @param  $resolver
     * @param  string   $database
     * @param  string   $table
     * @return void
     */
    public function __construct(Connection $resolver, $database, $table)
    {
        $this->table = $table;
        $this->resolver = $resolver;
        $this->database = $database;
    }

    /**
     * Log a failed job into storage.
     *
     * @param  string     $connection
     * @param  string     $queue
     * @param  string     $payload
     * @param  \Exception $exception
     * @return int|null
     */
    public function log($connection, $queue, $payload, $exception)
    {
        $failed_at = Carbon::now();

        $exception = (string)$exception;

        return $this->resolver->createCommand()->insert(
            $this->table, compact(
                'connection', 'queue', 'payload', 'exception', 'failed_at'
            )
        )->execute();
    }

    /**
     * Get a list of all of the failed jobs.
     *
     * @return array
     */
    public function all()
    {
        return $this->resolver->createCommand('SELECT * FROM ' . $this->table . ' order by id desc')->queryAll();
    }

    /**
     * Get a single failed job.
     *
     * @param  mixed $id
     * @return object|null
     */
    public function find($id)
    {
        return $this->resolver->createCommand("SELECT * FROM " . $this->table . ' WHERE id=' . $id)->queryOne();
    }

    /**
     * Delete a single failed job from storage.
     *
     * @param  mixed $id
     * @return bool
     */
    public function forget($id)
    {
        return $this->resolver->createCommand()->delete($this->table, ['id' => $id])->execute();
    }

    /**
     * Flush all of the failed jobs from storage.
     *
     * @return void
     */
    public function flush()
    {
        $this->resolver->createCommand()->truncateTable($this->table)->execute();
    }
}
