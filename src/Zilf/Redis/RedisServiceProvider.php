<?php

namespace Zilf\Redis;

use Zilf\Helpers\Arr;
use Zilf\System\Zilf;

class RedisServiceProvider
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
     * @throws \Exception
     */
    public function register()
    {
        /**
         * redis 的连接对象
         */
        Zilf::$container->register('redis',function (){
            $config = Zilf::$container->getShare('config')->get('cache.redis');

            return new RedisManager(Arr::pull($config, 'client', 'predis'), $config);
        });

        /**
         * redis的连接服务
         */
        Zilf::$container->register('redis.connection',function (){
            return Zilf::$container->get('redis')->connection();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['redis', 'redis.connection'];
    }
}
