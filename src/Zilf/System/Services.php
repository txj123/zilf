<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-4-27
 * Time: 上午11:05
 */

namespace Zilf\System;


use Zilf\Cache\CacheManager;
use Zilf\Config\LoadConfig;
use Zilf\Log\Writer;
use Zilf\Support\Request;

class Services
{
    protected $container;

    /**
     * 注册服务
     *
     * Services constructor.
     */
    function __construct()
    {
        $this->container = Zilf::$container;
        Zilf::$container->setAlias($this->getAliasClass());
        $this->setRegister();
    }

    public function setRegister(){
        $config = require_once(APP_PATH.'/config/config.php');

        /**
         * 注册配置信息类
         */
        $this->register('config',function ($config) use ($config){
            return new LoadConfig($config);
        });

        /**
         * http请求类
         */
        $this->register('request',function (){
            return Request::createFromGlobals();
        });

        /**
         * 日志类
         */
        $this->register('log',function (){
            $monolog_config = [
                'handlers' => [
                    [
                        'type' => 'StreamHandler',
                        'level' => 'debug',
                    ]
                ]
            ];
            return new Writer(config('monolog',$monolog_config), config('runtime',APP_PATH . '/runtime'));
        });
    }

    public function getAliasClass()
    {
        return [
            'curl' => 'Zilf\Curl\Curl',
            'route' => 'Zilf\Routing\Route',
            'hashing' => 'Zilf\Security\Hashing\PasswordHashing',
            'crypt' => 'Zilf\Security\Encrypt\Crypt',
            'hashids' => 'Zilf\Security\Hashids\Hashids',
            'validator' => 'Zilf\Validation\Factory',
            'files' => 'Zilf\Filesystem\Filesystem',
            'cache' => 'Zilf\Cache\CacheManager',
//            'Mail',
//            'Redis',
//            'Request',
//            'Response',
//            'Session',
//            'Cookie',
//            'view',
//            'Cache',
//            'DB',
//            'File',
        ];
    }

    /**
     * @param $name
     * @param $callback
     * @param array $params
     */
    private function register($name,$callback,$params=[]){
        $this->container->register($name,$callback,$params);
    }
}