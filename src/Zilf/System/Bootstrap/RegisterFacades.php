<?php

namespace Zilf\System\Bootstrap;

use Zilf\System\Application;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Support\Facades\Facade;

class RegisterFacades
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

//        AliasLoader::getInstance(array_merge(
//            $app->make('config')->get('app.aliases', []),
//            $app->make(PackageManifest::class)->aliases()
//        ))->register();
    }
}
