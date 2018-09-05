<?php

namespace Zilf\Security\Hashids;

use Zilf\System\Zilf;

class HashidsServiceProvider
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
        Zilf::$container->register('hashids', 'Zilf\Security\Hashids\Hashids');
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
