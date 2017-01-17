<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-12-19
 * Time: 上午10:32
 */

namespace Zilf\Support;


use Zilf\Db\Command;
use Zilf\Db\Connection;
use Zilf\Db\Query;
use Zilf\System\Zilf;

class DB
{
    /**
     * @param string $db_config
     * @return Connection
     */
    public static function connection($db_config=''){
        if(is_array($db_config)){
             Zilf::$container->set('db',$db_config);
        }elseif(!empty($db_config)){
             Zilf::$container->set('db',Zilf::$container->get('config')->get($db_config));
        }
        return Zilf::$container->getShare('db');
    }

    /**
     * @param null $sql
     * @param array $params
     * @return Command the DB command
     */
    public static function  createCommand($sql = null, $params = []){
        return Zilf::$container->getShare('db')->createCommand($sql,$params);
    }

    /**
     * 查询构建器
     *
     * @return Query
     */
    public static function query(){
        return new Query();
    }
}