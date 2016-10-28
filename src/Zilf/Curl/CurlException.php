<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-8-31
 * Time: 下午1:54
 */

namespace Zilf\Curl;


class CurlException extends \Exception
{
    static $error = array(
        2001 => '请求的url不存在！'
    );

    function __construct($message, $code='', \Exception $previous = null)
    {
        parent::__construct($message);
    }
}