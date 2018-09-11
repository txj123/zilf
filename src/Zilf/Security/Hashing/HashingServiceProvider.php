<?php

namespace Zilf\Security\Hashing;

use RuntimeException;
use Zilf\Helpers\Str;
use Zilf\System\Zilf;

class HashingServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Zilf::$container->register('hashing', 'Zilf\Security\Hashing\PasswordHashing');
    }
}
