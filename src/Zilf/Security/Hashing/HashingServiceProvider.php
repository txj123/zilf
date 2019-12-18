<?php

namespace Zilf\Security\Hashing;

use Illuminate\Support\ServiceProvider;
use RuntimeException;
use Zilf\Helpers\Str;
use Zilf\System\Zilf;

class HashingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Zilf::$app->instance('hashing', new PasswordHashing());
    }
}
