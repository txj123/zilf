<?php

namespace Zilf\System\Bootstrap;

use Zilf\System\Application;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->registerConfiguredProviders();
    }
}
