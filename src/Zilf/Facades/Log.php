<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-3-31
 * Time: 下午2:25
 */

namespace Zilf\Facades;


/**
 *
 * @method  static mixed emergency($message, $context = array())
 * @method  static mixed alert($message, $context = array())
 * @method  static mixed critical($message, $context = array())
 * @method  static mixed error($message, $context = array())
 * @method  static mixed warning($message, $context = array())
 * @method  static mixed notice($message, $context = array())
 * @method  static mixed info($message, $context = array())
 * @method  static mixed debug($message, $context = array())
 * @method  static mixed log($level, $message, $context = array())
 * @method  static mixed write($level, $message, $context = array())
 * @method  static void useFiles($path, $level = 'debug')
 * @method  static void useDailyFiles($path, $days = 0, $level = 'debug')
 * @method  static \Psr\Log\LoggerInterface useSyslog($name = 'zilf', $level = 'debug')
 * @method  static void useErrorLog($level = 'debug', $messageType = ErrorLogHandler::OPERATING_SYSTEM)
 * @method  static \Monolog\Logger getMonolog()
 *
 * Class Log
 * @package Zilf\Facades
 */

class Log extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'log';
    }
}