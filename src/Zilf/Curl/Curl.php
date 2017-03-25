<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-8-31
 * Time: 下午1:54
 */

namespace Zilf\Curl;

class Curl
{
    /**
     * 请求的url网址
     * @var string
     */
    public $_url;

    /**
     * @var string
     */
    public $_referer;

    /**
     * 请求的cookie信息
     * @var string
     */
    public $_cookies;

    /**
     * 存储cookie的路径
     *
     * @var string
     **/
    public $_cookie_file;


    /**
     * 请求的方式
     * @var string
     */
    public $_method;

    /**
     * 请求的头信息
     * @var array
     */
    public $_headers = [];

    /**
     * 发送请求的配置参数
     * @var array
     */
    public $_options = [];

    /**
     * 请求的数据
     * @var array
     */
    public $_parameters = [];

    /**
     * 请求的响应时间
     * @var int
     */
    public $_timeout = 20;


    /**
     * The user agent to send along with requests
     *
     * @var string
     **/
    public $_user_agent = 'Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.htm)';

    /**
     * curl请求的句柄
     */
    public $_curl_obj;

    /**
     * @var bool
     * 是否上传文件
     */
    public $_is_upload = false;

    /**
     * 请求后返回内容
     * @var string
     */
    private $_content = '';

    public $start_time;


    /**
     * Curl constructor.
     * @param string $method
     * @param string $url
     * @param string $parameters
     * @param array $headers
     * @throws \ErrorException
     */
    function __construct($method = '', array $headers = [])
    {
        if (!extension_loaded('curl')) {
            throw new \ErrorException('curl library is not loaded');
        }

        $this->start_time = microtime();

        $this->_init($method, '', '', $headers);
    }

    /**
     * @param string $url
     * @param array $parameters
     * @param array $headers
     * @return $this
     */
    function get($url, $parameters = [], $headers = [])
    {
        $this->_init('GET', $url, $parameters, $headers);

        return $this;
    }

    /**
     * @param string $url
     * @param string $parameters
     * @param array $headers
     * @return $this
     */
    function post($url, $parameters = '', $headers = [])
    {
        $this->_init('POST', $url, $parameters, $headers);

        return $this;
    }

    /**
     * @param string $url
     * @param array $parameters
     * @param array $headers
     * @return $this
     */
    function post_upload($url, array $parameters = [], array $headers = [])
    {
        $this->_init('POST', $url, $parameters, $headers);
        $this->_is_upload = true;

        return $this;
    }

    /**
     * @param string $url
     * @param array $parameters
     * @param array $headers
     * @return $this
     */
    function head($url, array $parameters = [], array $headers = [])
    {
        $this->_init('HEAD', $url, $parameters, $headers);

        return $this;
    }

    /**
     * @param string $url
     * @param array $parameters
     * @param array $headers
     * @return $this
     */
    function put($url, array $parameters = [], array $headers = [])
    {
        $this->_init('PUT', $url, $parameters, $headers);

        return $this;
    }


    /**
     * @return CurlResponse
     */
    function exec()
    {

        //curl 请求的句柄
        $this->_curl_obj = curl_init();

        $response = $this->_request();

        //关闭句柄
        curl_close($this->_curl_obj);

        return $response;
    }

    /**
     * @return null|CurlResponse
     * @throws CurlException
     */
    private function _request()
    {
        $this->_set_params();
        $this->_set_method();

        if (empty($this->_url)) {
            throw new CurlException('你请求的网址，不存在！', 404);
        }

        //请求的网址
        $this->_options[CURLOPT_URL] = $this->_url;

        curl_setopt_array($this->_curl_obj, $this->_options);
        $this->_content = curl_exec($this->_curl_obj);

        //直接输出
        if ($this->_options[CURLOPT_RETURNTRANSFER] === false) {
            return null;
        } else {
            return new CurlResponse($this);
        }
    }


    /**
     * @param string $method
     * @param string $url
     * @param string $parameters
     * @param array $headers
     */
    private function _init($method = '', $url = '', $parameters = '', array $headers = [])
    {
        //请求方式
        if (!empty($method))
            $this->_method = $method;

        //请求地址
        if (!empty($url))
            $this->_url = $url;

        //设置参数
        if (!empty($parameters)) {
            if (is_array($parameters)) {
                $this->_set_data($this->_parameters, $parameters);
            } elseif (is_string($parameters)) {
                $this->_parameters = $parameters;
            }
        }

        //设置头信息
        $this->_set_data($this->_headers, $headers);
    }

    ///////////////////////////// 设置过期时间 //////////////////////////////////////////////////
    public function set_time_out($time){
        $this->_timeout = $time;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////// 设置请求的参数数据 //////////////////////////////////////////////////
    public function get_parameters($key = '')
    {
        if (is_array($this->_parameters)) {
            return $this->_get_data($this->_parameters, $key);
        } else {
            return $this->_parameters;
        }
    }

    public function set_parameters($parameters)
    {
        if (is_array($parameters)) {
            $this->_set_data($this->_parameters, $parameters);
        } else {
            $this->_parameters = $parameters;
        }

        return $this;
    }

    public function add_parameter($key, $value)
    {
        $this->_add_data($this->_parameters, $key, $value);
    }
    ///////////////////////////////////////////////////////////////////////////////


    ////////////////////////////////// 请求的头信息 /////////////////////////////////////////////
    function get_headers($key = '')
    {
        return $this->_get_data($this->_headers, $key);
    }

    function set_headers(array $headers = [])
    {
        return $this->_set_data($this->_headers, $headers);
    }

    function add_header($key, $value)
    {
        return $this->_add_data($this->_headers, $key, $value);
    }
    ///////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////curl_opt 参数 ////////////////////////////////////////////////
    function get_options($key = '')
    {
        return $this->_get_data($this->_options, $key);
    }

    function set_options(array $options = [])
    {
        $this->_set_data($this->_options, $options);
        return $this;
    }

    function add_option($key, $value)
    {
        return $this->_add_data($this->_options, $key, $value);
    }
    ///////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////cookie_file 参数 ////////////////////////////////////////////////
    function set_cookie_file($cookie_path)
    {
        $this->_cookie_file = $cookie_path;

        return $this;
    }

    function get_cookie_file()
    {
        return $this->_cookie_file;
    }
    ///////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////cookies 参数 ////////////////////////////////////////////////
    function set_cookies($cookies)
    {
        if (is_array($cookies)) {
            $this->_cookies = implode(';', $cookies);
        } else {
            $this->_cookies = $cookies;
        }

        return $this;
    }

    function get_cookies()
    {
        return $this->_cookies;
    }
    ///////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////referer 参数 ////////////////////////////////////////////////
    function set_referer($referer)
    {
        $this->_referer = $referer;

        return $this;
    }

    function get_referer()
    {
        return $this->_referer;
    }
    ///////////////////////////////////////////////////////////////////////////////


    ///////////////////////////////_user_agent 参数 ////////////////////////////////////////////////
    function set_user_agent($user_agent)
    {
        $this->_user_agent = $user_agent;

        return $this;
    }

    function get_user_agent()
    {
        return $this->_user_agent;
    }
    ///////////////////////////////////////////////////////////////////////////////


    /**
     * @param $param1
     * @param array $param2
     */
    private function _set_data(&$param1, array $param2 = [])
    {
        // 不用使用array_merge 合并索引数组  因为索引的键值不能保存
        if (!empty($param2)) {
            foreach ($param2 as $key => $value) {
                $param1[$key] = $value;
            }
        }
    }

    /**
     * 给数组添加新的参数  相同的参数将被覆盖掉
     * @param $param1
     * @param $key
     * @param $value
     */
    private function _add_data(&$param1, $key, $value)
    {
        $param1[$key] = $value;
    }

    /**
     * 获取参数数组  或者 数组的某个参数
     * @param $param1
     * @param string $key
     * @return mixed
     */
    private function _get_data($param1, $key = '')
    {
        if ($key) {
            return $param1[$key];
        } else {
            return $param1;
        }
    }


    /**
     * CURL默认的参数
     */
    private function _set_params()
    {
        if ($this->_user_agent) {
            $this->_options[CURLOPT_USERAGENT] = $this->_user_agent;
        }

        if ($this->_referer) {
            $this->_options[CURLOPT_REFERER] = $this->_referer;
        }

        if ($this->_headers) {
            $headers = array();
            //格式化headers信息
            foreach ($this->_headers as $key => $value) {
                $headers[] = $key . ': ' . $value;
            }

            $this->_options[CURLOPT_HTTPHEADER] = $headers;  //设置请求的header信息
            unset($headers);
        }


        if ($this->_cookies) {
            $this->_options[CURLOPT_COOKIE] = $this->_cookies;   //设置请求的cookie信息
        }


        if ($this->_cookie_file) {
            $this->_options[CURLOPT_COOKIEJAR] = $this->_cookie_file;   //连接时把获得的cookie存为文件
            $this->_options[CURLOPT_COOKIEFILE] = $this->_cookie_file;  //在访问其他页面时拿着这个cookie文件去访问
        }

        $this->_options[CURLOPT_AUTOREFERER] = true;  //TRUE时将根据 Location: 重定向时，自动设置 header 中的Referer:信息。

        //启用时会将头文件的信息作为数据流输出。
        if(!isset($this->_options[CURLOPT_HEADER])) {
            $this->_options[CURLOPT_HEADER] = true;
        }

        if(!isset($this->_options[CURLINFO_HEADER_OUT])) {
            $this->_options[CURLINFO_HEADER_OUT] = true;   //TRUE 时追踪句柄的请求字符串。
        }

        if(!isset($this->_options[CURLOPT_RETURNTRANSFER])){
            $this->_options[CURLOPT_RETURNTRANSFER] = true;  //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
        }

        if(!isset($this->_options[CURLOPT_CONNECTTIMEOUT])) {
            $this->_options[CURLOPT_CONNECTTIMEOUT] = $this->_timeout;  //在尝试连接时等待的秒数。设置为0，则无限等待。
        }
    }

    /**
     * 设置请求的方法，以及请求参数的设置
     * @throws \Exception
     */
    private function _set_method()
    {
        switch (strtoupper($this->_method)) {
            case 'HEAD':
                $this->_add_data($this->_options, CURLOPT_NOBODY, true);  ////CURLOPT_NOBODY TRUE 时将不输出 BODY 部分。同时 Mehtod 变成了 HEAD。修改为 FALSE 时不会变成 GET。
                break;

            case 'GET':

                if(!empty($this->_parameters)){
                    if ( is_array($this->_parameters)) {  //参数是数组
                        $url = '';
                        $url .= (stripos($this->_url, '?') !== false) ? '&' : '?';
                        $url .= http_build_query($this->_parameters, '', '&');
                        $this->_url .= $url;
                    } else { //参数是字符串
                        $url = '';
                        $url .= (stripos($this->_url, '?') !== false) ? '&' : '?';
                        $url .= $this->_parameters;
                        $this->_url .= $url;
                    }

                    unset($url);
                }

                $this->_add_data($this->_options, CURLOPT_HTTPGET, true);  //TRUE 时会设置 HTTP 的 method 为 GET

                break;

            case 'POST':

                if (!empty($this->_parameters) && is_array($this->_parameters) && !$this->_is_upload) { //参数是数组
                    $data = http_build_query($this->_parameters); //为了更好的兼容性
                } else {  //参数是字符串
                    $data = $this->_parameters;
                }

                $this->_add_data($this->_options, CURLOPT_POSTFIELDS, $data);  //post请求的数据
                $this->_add_data($this->_options, CURLOPT_POST, true);  //TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded，是 HTML 表单提交时最常见的一种。

                unset($data);

                break;

            default:
                throw new CurlException('你设置请求方式！');
        }
    }

    ////////////////////////////////////////////////////////////////////////
    public function get_curl_obj()
    {
        return $this->_curl_obj;
    }

    /**
     * @return string
     */
    public function get_content()
    {
        return $this->_content;
    }

    /**
     * 获取请求的url地址
     * @return string
     */
    public function get_url()
    {
        return $this->_url;
    }

    /**
     * 获取请求方式
     */
    public function get_method()
    {
        return $this->_method;
    }

    /**
     * @param $url
     * @return $this
     */
    public function set_url($url){
        $this->_url = $url;
        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function set_method($method){
        $this->_method = $method;
        return $this;
    }
}
