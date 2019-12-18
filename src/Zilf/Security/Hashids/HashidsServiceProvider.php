<?php

namespace Zilf\Security\Hashids;

use Illuminate\Support\ServiceProvider;
use Zilf\System\Zilf;

class HashidsServiceProvider extends ServiceProvider
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
        Zilf::$app->instance('hashids', new Hashids());
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['hashids'];
    }
}
