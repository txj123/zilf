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
     * @param string $databaseName
     * @return Connection
     */
    public static function connection($databaseName=''){
        $database = $databaseName ? $databaseName : Zilf::$app->database;
        Zilf::$app->setDb($database);
        return Zilf::$container->getShare($database);
    }

    /**
     * @param null $sql
     * @param array $params
     * @return Command the DB command
     */
    public static function  createCommand($sql = null, $params = []){
        return Zilf::$container->getShare(Zilf::$app->database)->createCommand($sql,$params);
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