<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-12-2
 * Time: 上午11:45
 */

namespace Zilf\Support;

use Zilf\System\Zilf;

class Request extends \Zilf\HttpFoundation\Request
{
    /**
     * @return \Zilf\HttpFoundation\Request
     */
    public static function getInstance()
    {
        return Zilf::$container->getShare('request');
    }

    /**
     * @return \Zilf\HttpFoundation\ParameterBag
     */
    public static function request()
    {
        return Zilf::$container->getShare('request')->request;
    }

    /**
     * @return \Zilf\HttpFoundation\ParameterBag
     */
    public static function query()
    {
        return Zilf::$container->getShare('request')->query;
    }

    /**
     * @return \Zilf\HttpFoundation\ParameterBag
     */
    public static function cookie()
    {
        return Zilf::$container->getShare('request')->cookie;
    }

    /**
     * @return \Zilf\HttpFoundation\ServerBag
     */
    public static function server()
    {
        return Zilf::$container->getShare('request')->server;
    }
}