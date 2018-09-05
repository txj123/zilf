<?php

namespace Zilf\Db;

use Zilf\Helpers\Arr;
use Zilf\System\Zilf;

class DbServiceProvider
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
        $params = Zilf::$container->getShare('config')->get('databases');
        foreach ($params as $key => $row) {
            Zilf::$container->register('db.' . $key, function () use ($row) {
                    $connect = new Connection($row);
                    $connect->open();
                    return $connect;
                }
            );
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['db'];
    }
}
