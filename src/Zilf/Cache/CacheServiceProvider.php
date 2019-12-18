<?php

namespace Zilf\Cache;

use Zilf\Support\ServiceProvider;
use Zilf\System\Zilf;

class CacheServiceProvider extends ServiceProvider
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
        Zilf::$container->register(
            'cache', function () {
                return new CacheManager();
            }
        );

        Zilf::$container->register(
            'cache.store', function ($app) {
                return Zilf::$app->get('cache')->driver();
            }
        );

        Zilf::$container->register(
            'memcached.connector', function () {
                return new MemcachedConnector;
            }
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
            'cache', 'cache.store', 'memcached.connector',
        ];
    }
}
