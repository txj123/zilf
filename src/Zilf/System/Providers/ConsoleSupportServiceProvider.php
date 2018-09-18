<?php

namespace Zilf\System\Providers;

use Zilf\Support\AggregateServiceProvider;
//use Zilf\Database\MigrationServiceProvider;

class ConsoleSupportServiceProvider extends AggregateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ArtisanServiceProvider::class,
//        MigrationServiceProvider::class,
    ];
}
