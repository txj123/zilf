<?php

namespace Zilf\System\Bootstrap;

use Zilf\System\Application;

class BootProviders
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Zilf\System\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $app->boot();
    }
}
