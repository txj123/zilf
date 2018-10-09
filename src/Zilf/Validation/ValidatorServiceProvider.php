<?php

namespace Zilf\Validation;

use Zilf\System\Zilf;

class ValidatorServiceProvider
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
        Zilf::$container->register('validator', function () {
                return new Factory();
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
        return ['validator'];
    }
}
