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
    public static $database = 'default';

    /**
     * @param string $db_config
     * @return Connection
     */
    public static function connection($databaseName=''){
        self::$database = $databaseName ? $databaseName : self::$database;
        Zilf::$app->setDb(self::$database);
        return Zilf::$container->getShare(self::$database);
    }

    /**
     * @param null $sql
     * @param array $params
     * @return Command the DB command
     */
    public static function  createCommand($sql = null, $params = []){
        return Zilf::$container->getShare(self::$database)->createCommand($sql,$params);
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