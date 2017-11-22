<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-2
 * Time: 上午10:33
 */

namespace Zilf\DataCrawler;


use Zilf\Curl\Curl;
use Zilf\Finder\Finder;

class Client
{
    /**
     * @var array
     * 需要采集的url
     */
    private $urls = array();
    private $rules;
    public $msg =array();

    public $charset;
    public $curl_config;

    /**
     * @var array
     * 附加参数
     */
    private $extra=array();

    public $curl;

    function __construct(Curl $curl=null)
    {
        set_time_limit(0);

        if($curl) {
            $this->curl = $curl;
        }else{
            $this->curl = new Curl();
        }
    }

    /**
     * @param $urls
     * @param $rules
     */
    function request($urls,$rules,$curl_config=array(),$charset='')
    {
        $this->urls = (new CaijiUrl($urls))->getUrls();
        $this->rules = (new CaijiRules($rules))->getRules();
        $this->curl_config = $curl_config;
        $this->charset = $charset;

        return $this;
    }

    function exec()
    {
        $data = array();

        foreach ($this->urls as $url){
            if($url) {
                //curl请求配置设置
                if($this->curl_config) {
                    $type = isset($this->curl_config['type']) ? $this->curl_config['type'] :'';
                    $params = isset($this->curl_config['params']) ? $this->curl_config['params'] :'';
                    $options = isset($this->curl_config['options']) ? $this->curl_config['options'] :'';

                    if($type == 'POST') {
                        $curl = $this->curl->post($url, $params, $options);
                    }elseif($type == 'GET') {
                        $curl = $this->curl->get($url, $params, $options);
                    }else{
                        $class = strtolower($type);
                        $curl = $this->curl->$class($url, $params, $options);
                    }
                }else{  //默认请求方式是get请求
                    $curl = $this->curl->get($url);
                }

                $content = $curl->getResponse();
                //                var_dump($content);
                if(empty($this->charset)) {
                    $this->charset = $curl->getCharset();
                }

                if($curl->getHttpCode() != 200) {
                    $this->msg[] = '网址：'.$url.' 抓取失败，原因：'.$curl->getCurlErrorMessage().'，错误码：'.$curl->getCurlErrorCode();
                    continue;
                }

                //住区数据
                $crawler = new Crawler($content, $this->rules, $url, $this->charset);
                $result = $crawler->get();
                $this->msg = array_merge($this->msg, $crawler->msg);

                $data[] = array_merge($result, $this->_default($url));
            }
        }

        return $data;
    }


    private function _default($url)
    {
        $params = array();

        $params['_url'] = $url;
        $params['_md5_url'] = md5($url);
        $params['_add_time'] = time();

        return $params;
    }

    /**
     * @return Curl
     * 返回采集器curl
     */
    function getCurl()
    {
        return $this->curl;
    }

}