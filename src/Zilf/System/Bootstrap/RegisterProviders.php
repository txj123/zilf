<?php

namespace Zilf\System\Bootstrap;

use Zilf\System\Zilf;

class RegisterProviders
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap()
    {
        $providers = Zilf::$container->getShare('config')->get('services');

        foreach ($providers as $provider) {
            $instance = $this->createProvider($provider);
            $instance->register();
        }
    }

    /**
     * Create a new provider instance.
     *
     * @param  string $provider
     * @return \Zilf\Support\ServiceProvider
     */
    public function createProvider($provider)
    {
        return new $provider();
    }
}
