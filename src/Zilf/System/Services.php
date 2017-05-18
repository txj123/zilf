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
use Zilf\View\Compilers\BladeCompiler;
use Zilf\View\Engines\CompilerEngine;
use Zilf\View\Engines\EngineResolver;
use Zilf\View\Engines\FileEngine;
use Zilf\View\Engines\PhpEngine;
use Zilf\View\Factory;
use Zilf\View\FileViewFinder;

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

    /**
     *
     */
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


        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $this->register('view.engine.resolver','\Zilf\View\Engines\EngineResolver');
        $this->register('view.finder',function (){
            $path = APP_PATH.'/resources';
            return new FileViewFinder(Zilf::$container['files'], [$path]);
        });


        $this->register('view',function (){
            /**
             * @var $resolver EngineResolver
             */
            $resolver = Zilf::$container['view.engine.resolver'];
            foreach (['file', 'php', 'blade'] as $engine) {
                $this->{'register'.ucfirst($engine).'Engine'}($resolver);
            }

            $finder = Zilf::$container['view.finder'];
            $env = new Factory($resolver, $finder);

            return $env;
        });

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

    /**
     * Register the file engine implementation.
     *
     * @param  \Zilf\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerFileEngine($resolver)
    {
        $resolver->register('file', function () {
            return new FileEngine();
        });
    }

    /**
     * Register the PHP engine implementation.
     *
     * @param  \Zilf\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerPhpEngine($resolver)
    {
        $resolver->register('php', function () {
            return new PhpEngine();
        });
    }

    /**
     * Register the Blade engine implementation.
     *
     * @param  \Zilf\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        // The Compiler engine requires an instance of the CompilerInterface, which in
        // this case will be the Blade compiler, so we'll first create the compiler
        // instance to pass into the engine so it can compile the views properly.
        $this->register('blade.compiler',function () {
            $cachePath = APP_PATH.'/runtime/views';
            return new BladeCompiler(
                Zilf::$container['files'], $cachePath
            );
        });

        $resolver->register('blade', function () {
            return new CompilerEngine(Zilf::$container['blade.compiler']);
        });
    }
}