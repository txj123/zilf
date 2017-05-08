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
    public function getInstance()
    {
        return Zilf::$container->getShare('request');
    }

    /**
     * @return \Zilf\HttpFoundation\ParameterBag
     */
    public function query()
    {
        return self::getInstance()->query;
    }

    /**
     * @return \Zilf\HttpFoundation\ParameterBag
     */
    public function request()
    {
        return self::getInstance()->request;
    }

    /**
     * @return \Zilf\HttpFoundation\ParameterBag
     */
    public function attributes()
    {
        return self::getInstance()->attributes;
    }

    /**
     * @return \Zilf\HttpFoundation\ParameterBag
     */
    public function cookies()
    {
        return self::getInstance()->cookies;
    }

    /**
     * @return \Zilf\HttpFoundation\FileBag
     */
    public function files()
    {
        return self::getInstance()->files;
    }

    /**
     * @return \Zilf\HttpFoundation\ServerBag
     */
    public function server()
    {
        return self::getInstance()->server;
    }

    /**
     * @return \Zilf\HttpFoundation\HeaderBag
     */
    public function headers()
    {
        return self::getInstance()->headers;
    }

    /**
     * @return string
     */
    public function method()
    {
        return self::getInstance()->getMethod();
    }

    /**
     * Get the URL (no query string) for the request.
     *
     * @return string
     */
    public function url()
    {
        return rtrim(preg_replace('/\?.*/', '', $this->getUri()), '/');
    }

    /**
     * Get the full URL for the request.
     *
     * @return string
     */
    public function fullUrl()
    {
        $query = $this->getQueryString();

        $question = $this->getBaseUrl().$this->getPathInfo() == '/' ? '/?' : '?';

        return $query ? $this->url().$question.$query : $this->url();
    }
}