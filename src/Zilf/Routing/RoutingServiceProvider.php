<?php

namespace Zilf\Routing;

use Illuminate\Support\ServiceProvider;
use Zilf\System\Zilf;

class RoutingServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $config = Zilf::$app->get('config');
        Zilf::$app->singleton('router', function () use ($config) {
            $route = new Router();
            $route->lazy($config['app.url_lazy_route'])
                ->autoSearchController($config['app.controller_auto_search'])
                ->mergeRuleRegex($config['app.route_rule_merge']);
            return $route;
        });

        Zilf::$app->singleton('ruleName', function () {
            return new RuleName();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['router', 'ruleName'];
    }
}