<?php

namespace Zilf\Queue;

use Illuminate\Support\ServiceProvider;
use Zilf\Queue\Connectors\SqsConnector;
use Zilf\Queue\Connectors\NullConnector;
use Zilf\Queue\Connectors\SyncConnector;
use Zilf\Queue\Connectors\RedisConnector;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Zilf\Queue\Connectors\DatabaseConnector;
use Zilf\Queue\Failed\NullFailedJobProvider;
use Zilf\Queue\Connectors\BeanstalkdConnector;
use Zilf\Queue\Failed\DatabaseFailedJobProvider;
use Zilf\System\Zilf;

class QueueServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerManager();

        $this->registerConnection();

        $this->registerWorker();

        $this->registerListener();

        $this->registerFailedJobServices();
    }

    /**
     * Register the queue manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        Zilf::$container->register(
            'queue', function () {
                // Once we have an instance of the queue manager, we will register the various
                // resolvers for the queue connectors. These connectors are responsible for
                // creating the classes that accept queue configs and instantiate queues.
                return tap(
                    new QueueManager(), function ($manager) {
                        $this->registerConnectors($manager);
                    }
                );
            }
        );
    }

    /**
     * Register the default queue connection binding.
     *
     * @return void
     */
    protected function registerConnection()
    {
        Zilf::$container->register(
            'queue.connection', function () {
                return Zilf::$container['queue']->connection();
            }
        );
    }

    /**
     * Register the connectors on the queue manager.
     *
     * @param  \Illuminate\Queue\QueueManager $manager
     * @return void
     */
    public function registerConnectors($manager)
    {
        foreach (['Null', 'Sync', 'Database', 'Redis', 'Beanstalkd', 'Sqs'] as $connector) {
            $this->{"register{$connector}Connector"}($manager);
        }
    }

    /**
     * Register the Null queue connector.
     *
     * @param  \Illuminate\Queue\QueueManager $manager
     * @return void
     */
    protected function registerNullConnector($manager)
    {
        $manager->addConnector(
            'null', function () {
                return new NullConnector;
            }
        );
    }

    /**
     * Register the Sync queue connector.
     *
     * @param  \Illuminate\Queue\QueueManager $manager
     * @return void
     */
    protected function registerSyncConnector($manager)
    {
        $manager->addConnector(
            'sync', function () {
                return new SyncConnector;
            }
        );
    }

    /**
     * Register the database queue connector.
     *
     * @param  \Illuminate\Queue\QueueManager $manager
     * @return void
     */
    protected function registerDatabaseConnector($manager)
    {
        $manager->addConnector(
            'database', function () {
                return new DatabaseConnector(Zilf::$container->getShare('db.default'));
            }
        );
    }

    /**
     * Register the Redis queue connector.
     *
     * @param  \Illuminate\Queue\QueueManager $manager
     * @return void
     */
    protected function registerRedisConnector($manager)
    {
        $manager->addConnector(
            'redis', function () {
                return new RedisConnector(Zilf::$container->getShare('redis'));
            }
        );
    }

    /**
     * Register the Beanstalkd queue connector.
     *
     * @param  \Illuminate\Queue\QueueManager $manager
     * @return void
     */
    protected function registerBeanstalkdConnector($manager)
    {
        $manager->addConnector(
            'beanstalkd', function () {
                return new BeanstalkdConnector;
            }
        );
    }

    /**
     * Register the Amazon SQS queue connector.
     *
     * @param  \Illuminate\Queue\QueueManager $manager
     * @return void
     */
    protected function registerSqsConnector($manager)
    {
        $manager->addConnector(
            'sqs', function () {
                return new SqsConnector;
            }
        );
    }

    /**
     * Register the queue worker.
     *
     * @return void
     */
    protected function registerWorker()
    {
        Zilf::$container->register(
            'queue.worker', function () {
                return new Worker(Zilf::$container['queue']);
            }
        );
    }

    /**
     * Register the queue listener.
     *
     * @return void
     */
    protected function registerListener()
    {
        Zilf::$container->register(
            'queue.listener', function () {
                return new Listener(Zilf::$app->basePath());
            }
        );
    }

    /**
     * Register the failed job services.
     *
     * @return void
     */
    protected function registerFailedJobServices()
    {
        Zilf::$container->register(
            'queue.failer', function () {
                $config = $this->app['config']['queue.failed'];

                return isset($config['table'])
                        ? $this->databaseFailedJobProvider($config)
                        : new NullFailedJobProvider;
            }
        );
    }

    /**
     * Create a new database failed job provider.
     *
     * @param  array $config
     * @return \Illuminate\Queue\Failed\DatabaseFailedJobProvider
     */
    protected function databaseFailedJobProvider($config)
    {
        return new DatabaseFailedJobProvider(
            $this->app['db'], $config['database'], $config['table']
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'queue', 'queue.worker', 'queue.listener',
            'queue.failer', 'queue.connection',
        ];
    }
}
