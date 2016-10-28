<?php

namespace Zilf\Loader;
use Zilf\ClassLoader\Psr4ClassLoader;

/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-8-28
 * Time: 下午9:17
 */
class Loader
{
    private $Psr4Loader;
    private $bundle;
    public $bundle_names;
    private $dir;


    function __construct()
    {
        $this->Psr4Loader = new Psr4ClassLoader();
    }

    function registerBundle($data){
        $this->bundle = (array)$data;

        if(is_array($data) || is_object($data)){
            foreach ($data as $key=>$value){
                $this->bundle_names[] = $key;
                $this->Psr4Loader->addPrefix(ucfirst(strtolower($key)),$value);
            }
        }
    }

    //注册目录类，以及函数
    function registerDir($data){

    }

    function registerNamespaces($data){
        if(is_array($data)){
            foreach ($data as $key=>$value){
                $this->Psr4Loader->addPrefix(ucfirst(strtolower($key)),$value);
            }
        }
    }

    function register(){
        $this->Psr4Loader->register();
    }

    function getBundle(){
        return $this->bundle_names;
    }
}