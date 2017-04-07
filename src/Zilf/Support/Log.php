<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-3-31
 * Time: 下午2:25
 */

namespace Zilf\Support;

use Zilf\Log\Writer;
use Zilf\System\Zilf;

class Log
{
    static $monolog = null;

    /**
     * @return Writer
     */
    public static function gerInstance(){
        self::$monolog = Zilf::$container->get('log');
        return self::$monolog;
    }

    /**
     * Log an emergency message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return mixed
     */
    public static function emergency($message, array $context = [])
    {
        return self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an alert message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return mixed
     */
    public static function alert($message, array $context = [])
    {
        return self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a critical message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return mixed
     */
    public static function critical($message, array $context = [])
    {
        return self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an error message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return mixed
     */
    public static function error($message, array $context = [])
    {
        return self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return mixed
     */
    public static function warning($message, array $context = [])
    {
        return self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return mixed
     */
    public static function notice($message, array $context = [])
    {
        return self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return mixed
     */
    public static function info($message, array $context = [])
    {
        return self::writeLog(__FUNCTION__,$message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param  string  $message
     * @param  array  $context
     * @return mixed
     */
    public static function debug($message, array $context = [])
    {
        return self::writeLog(__FUNCTION__,$message, $context);
    }

    protected static function writeLog($level, $message, $context)
    {
        if(config_helper('environment') != 'pro'){
            return self::gerInstance()->{$level}($message, $context);
        }
    }
}