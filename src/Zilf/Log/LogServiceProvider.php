<?php

namespace Zilf\Log;

use Zilf\Support\ServiceProvider;
use Zilf\System\Zilf;

class LogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Zilf::$container->register(
            'log', function () {
                return new LogManager();
            }
        );
    }
}
