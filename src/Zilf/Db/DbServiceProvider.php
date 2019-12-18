<?php

namespace Zilf\Db;

use Illuminate\Support\ServiceProvider;
use Zilf\System\Zilf;

class DbServiceProvider extends ServiceProvider
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
        $params = Zilf::$app->get('config')->get('databases');
        foreach ($params as $key => $row) {
            Zilf::$app->bind(
                'db.' . $key, function () use ($row) {
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
