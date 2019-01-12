<?php

namespace Zilf\Routing;


use Zilf\Support\ServiceProvider;
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
        Zilf::$container->register('router', function () {
            $route = new Router();
            $config = Zilf::$container->getShare('config');
            $route->lazy($config['app.url_lazy_route'])
                ->autoSearchController($config['app.controller_auto_search'])
                ->mergeRuleRegex($config['app.route_rule_merge']);

            return $route;
        });

        Zilf::$container->register('ruleName', function () {
            return new RuleName();
        });
    }
}