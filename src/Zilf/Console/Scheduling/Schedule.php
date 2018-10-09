<?php

namespace Zilf\Console\Scheduling;

use DateTimeInterface;
use Zilf\Console\Application;
use Illuminate\Container\Container;
use Zilf\Support\ProcessUtils;
use Zilf\System\Zilf;

class Schedule
{
    /**
     * All of the events on the schedule.
     *
     * @var \Zilf\Console\Scheduling\Event[]
     */
    protected $events = [];

    /**
     * The event mutex implementation.
     *
     * @var \Zilf\Console\Scheduling\EventMutex
     */
    protected $eventMutex;

    /**
     * The scheduling mutex implementation.
     *
     * @var \Zilf\Console\Scheduling\SchedulingMutex
     */
    protected $schedulingMutex;

    /**
     * Create a new schedule instance.
     *
     * @return void
     */
    public function __construct()
    {
        Zilf::$container->register(CacheEventMutex::class,function (){
            return new CacheEventMutex(Zilf::$container->getShare('cache'));
        });
        Zilf::$container->register(CacheSchedulingMutex::class,function (){
            return new CacheSchedulingMutex(Zilf::$container->getShare('cache'));
        });

        $this->eventMutex = Zilf::$container->getShare(CacheEventMutex::class);

        $this->schedulingMutex =  Zilf::$container->getShare(CacheSchedulingMutex::class);
    }

    /**
     * Add a new callback event to the schedule.
     *
     * @param  string|callable $callback
     * @param  array           $parameters
     * @return \Zilf\Console\Scheduling\CallbackEvent
     */
    public function call($callback, array $parameters = [])
    {
        $this->events[] = $event = new CallbackEvent(
            $this->eventMutex, $callback, $parameters
        );

        return $event;
    }

    /**
     * Add a new Artisan command event to the schedule.
     *
     * @param  string $command
     * @param  array  $parameters
     * @return \Zilf\Console\Scheduling\Event
     */
    public function command($command, array $parameters = [])
    {
        if (class_exists($command)) {
            $command = (new $command)->getName();
        }

        return $this->exec(
            Application::formatCommandString($command), $parameters
        );
    }

    /**
     * Add a new job callback event to the schedule.
     *
     * @param  object|string $job
     * @param  string|null   $queue
     * @return \Zilf\Console\Scheduling\CallbackEvent
     */
    public function job($job, $queue = null)
    {
        return $this->call(
            function () use ($job, $queue) {
                $job = is_string($job) ? resolve($job) : $job;

                if ($job instanceof ShouldQueue) {
                    dispatch($job)->onQueue($queue);
                } else {
                    dispatch_now($job);
                }
            }
        )->name(is_string($job) ? $job : get_class($job));
    }

    /**
     * Add a new command event to the schedule.
     *
     * @param  string $command
     * @param  array  $parameters
     * @return \Zilf\Console\Scheduling\Event
     */
    public function exec($command, array $parameters = [])
    {
        if (count($parameters)) {
            $command .= ' '.$this->compileParameters($parameters);
        }

        $this->events[] = $event = new Event($this->eventMutex, $command);

        return $event;
    }

    /**
     * Compile parameters for a command.
     *
     * @param  array $parameters
     * @return string
     */
    protected function compileParameters(array $parameters)
    {
        return collect($parameters)->map(
            function ($value, $key) {
                if (is_array($value)) {
                    $value = collect($value)->map(
                        function ($value) {
                            return ProcessUtils::escapeArgument($value);
                        }
                    )->implode(' ');
                } elseif (! is_numeric($value) && ! preg_match('/^(-.$|--.*)/i', $value)) {
                    $value = ProcessUtils::escapeArgument($value);
                }

                return is_numeric($key) ? $value : "{$key}={$value}";
            }
        )->implode(' ');
    }

    /**
     * Determine if the server is allowed to run this event.
     *
     * @param  \Zilf\Console\Scheduling\Event $event
     * @param  \DateTimeInterface                   $time
     * @return bool
     */
    public function serverShouldRun(Event $event, DateTimeInterface $time)
    {
        return $this->schedulingMutex->create($event, $time);
    }

    /**
     * Get all of the events on the schedule that are due.
     *
     * @return \Zilf\Support\Collection
     */
    public function dueEvents()
    {
        return collect($this->events)->filter->isDue();
    }

    /**
     * Get all of the events on the schedule.
     *
     * @return \Zilf\Console\Scheduling\Event[]
     */
    public function events()
    {
        return $this->events;
    }

    /**
     * Specify the cache store that should be used to store mutexes.
     *
     * @param  string $store
     * @return $this
     */
    public function useCache($store)
    {
        if ($this->eventMutex instanceof CacheEventMutex) {
            $this->eventMutex->useStore($store);
        }

        if ($this->schedulingMutex instanceof CacheSchedulingMutex) {
            $this->schedulingMutex->useStore($store);
        }

        return $this;
    }
}
