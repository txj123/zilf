<?php

namespace Zilf\System\Bootstrap;

use Zilf\System\Application;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredProviders();
    }
}
