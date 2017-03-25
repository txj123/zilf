<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-8-31
 * Time: 下午1:53
 */

namespace Zilf\Curl;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class CurlResponse
{
    /**
     * 返回的结果
     * @var string
     */
    private $_response;

    /**
     * 错误编码
     * @var int
     */
    private $_curl_errno;

    /**
     * 错误信息
     * @var string
     */
    private $_curl_error;

    /**
     * 响应信息
     * @var mixed
     */
    private $_curl_getinfo;

    /**
     * 响应头信息
     * @var array
     */
    private $_response_header;

    /**
     * @var Curl
     */
    public $curl;

    public $end_time;

    /**
     * CurlResponse constructor.
     * @param $curl
     */
    function __construct($curl)
    {
        $this->curl = $curl;

        $curl_init = $this->curl->get_curl_obj();

        $curl_error_code = curl_errno($curl_init);
        $curl_error_message = curl_error($curl_init);
        $curl_getinfo = curl_getinfo($curl_init);

        $this->_response = $this->curl->get_content();
        $this->_curl_errno = $curl_error_code;
        $this->_curl_error = $curl_error_message;
        $this->_curl_getinfo = $curl_getinfo;

        $this->_init();

        $this->end_time = microtime();
    }


    /**
     * 分离头信息 和 body
     */
    private function _init()
    {
        $pos = stripos($this->_response, '<!DOCTYPE');

        if ($pos != 0) { //方法一 分离头信息 和 body

            $this->_response_header = substr($this->_response, 0, $pos);
            $this->_response = substr($this->_response, $pos);

        } else { //方法二 分离头信息 和 body

            if (!(strpos($this->_response, "\r\n\r\n") === false)) {

                list($this->_response_header, $this->_response) = explode("\r\n\r\n", $this->_response, 2);

                while (strtolower(trim($this->_response_header)) === 'http/1.1 100 continue') {
                    list($this->_response_header, $this->_response) = explode("\r\n\r\n", $this->_response, 2);
                }
            }
        }
    }

    /**
     * 返回body信息
     * @return string
     */
    function get_response()
    {
        return $this->_response;
    }

    /**
     * 返回body信息
     * 将json类型的数据，转为数组
     *
     * @return mixed
     */
    function get_to_array(){
        return json_decode($this->_response);
    }

    /**
     * 返回body信息
     * 将数组转为json数组
     *
     * @return string
     */
    function get_to_json(){
        return json_encode($this->_response);
    }

    /**
     * 返回body信息
     * 转为jsonp格式返回
     *
     * @param string $callback
     * @return string
     */
    function get_to_jsonp($callback='callback_func'){
        return $callback . '(' . $this->_response . ')';
    }

    /**
     * 返回curl的请求状态
     * @return mixed
     */
    function get_curl_error_code()
    {
        return $this->_curl_errno;
    }

    /**
     * 返回curl请求的错误信息
     * @return mixed
     */
    function get_curl_error_message()
    {
        return $this->_curl_error;
    }

    /**
     * 返回页面响应信息的状态
     * @return mixed
     */
    function get_http_code()
    {
        return $this->_curl_getinfo['http_code'];
    }

    /**
     * 获取返回的 ContentType
     * @return mixed
     */
    function get_content_type()
    {
        return $this->_curl_getinfo['content_type'];
    }

    /**
     * @return string
     * 获取返回的字符编码
     */
    function get_charset()
    {
        $charset = '';

        //根据响应的信息获取编码
        $str = $this->get_content_type();
        if (preg_match('/charset=(.*)?/i', $str, $arr)) {
            $charset = isset($arr[1]) ? $arr[1] : '';
        }

        //通过页面的《meta 标签获取页面编码
        if (empty($charset)) {
            preg_match('/charset="?([\w-\d]*)"?/i', $this->get_response(), $re);
            $charset = isset($re[1]) ? $re[1] : '';
        }

        return $charset ? trim($charset, ';') : '';
    }

    /**
     * @return array
     */
    function get_curl_getInfo()
    {
        return $this->_curl_getinfo;
    }


    /**
     * @return array
     * 获取请求的头信息
     */
    function get_request_headers()
    {
        return isset($this->_curl_getinfo['request_header']) ? $this->_curl_getinfo['request_header'] : [];
    }

    /**
     * @return array
     * 获取响应的头信息
     */
    function get_response_headers()
    {
        return $this->_response_header;
    }

    /**
     * 显示采集的日志信息
     */
    function get_all()
    {
        return array(
            'url' => $this->curl->_url,
            'method' => $this->curl->_method,
            'time' => ($this->end_time - $this->curl->start_time),
            'curl_error_code' => $this->get_curl_error_code(),
            'curl_error_message' => $this->get_curl_error_message(),
            'charset' => $this->get_charset(),
            'http_code' => $this->get_http_code(),
            'content_type' => $this->get_content_type(),
            'curl_getInfo' => $this->get_curl_getInfo(),
            'request_headers' => $this->get_request_headers(),
            'response_headers' => $this->get_response_headers(),
            'response' => $this->get_response()
        );
    }
}