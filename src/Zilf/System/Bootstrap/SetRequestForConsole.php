<?php

namespace Zilf\System\Bootstrap;

use Illuminate\Http\Request;
use Zilf\System\Application;

class SetRequestForConsole
{
    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $uri = $app->make('config')->get('app.url', 'http://localhost');

        $components = parse_url($uri);

        $server = $_SERVER;

        if (isset($components['path'])) {
            $server = array_merge(
                $server, [
                'SCRIPT_FILENAME' => $components['path'],
                'SCRIPT_NAME' => $components['path'],
                ]
            );
        }

        $app->instance(
            'request', Request::create(
                $uri, 'GET', [], [], [], $server
            )
        );
    }
}
