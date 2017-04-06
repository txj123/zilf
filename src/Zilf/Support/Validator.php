<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-4-6
 * Time: 下午4:07
 */

namespace Zilf\Support;


use Zilf\System\Zilf;

class Validator
{
    static $obj = null;

    public static function __callStatic($method,$args){
        if(!self::$obj){
            self::$obj = Zilf::$container->get('validator');
        }

        return (self::$obj)->$method(...$args);
    }
}