<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-2
 * Time: 上午10:34
 */

namespace Zilf\DataCrawler;


class CaijiUrl
{
    private $caiji_urls = array();
    private $postion;

    function __construct($url)
    {

        //print_r($arr);

        $all_url = $this->parseUrl($url);
        $this->caiji_urls = $all_url;

    }

    /**
     * @param $url
     * 解析url [a-z]  [0-9],生成多条url
     * 获取所有的替换规则的数组
     */
    function parseUrl($url){
        $all_url = array($url);

        preg_match_all('/\{(.*?)\}/',$url,$arr);

        if(!empty($arr[0])){
            $num = count($arr[0]);
            for ($i=0; $i < $num; $i++){
                $all_url = $this->getNeedUrls($all_url);

            }
        }

        return $all_url;
    }

    /**
     * @param $urls
     * @return array
     * 获取替换之后的url数组
     */
    function getNeedUrls($urls){
        $new_url = array();
        foreach ($urls as $url){
            preg_match('/\{(.*?)\}/',$url,$arr);
            $param = $arr[0];
            $url_arr = $this->replace_urls($url,$param);
            $new_url = array_merge($new_url,$url_arr);
        }

        return $new_url;
    }

    /**
     * @param $url
     * @param $param
     * @return array
     * 替换参数
     */
    private function replace_urls($url,$param){
        $urls = array();
        $url_index = $this->get_params($param);

        foreach ($url_index as $value){
            $urls[] = preg_replace('/\{(.*?)\}/',$value,$url,1);
        }

        return $urls;
    }


    /**
     * @param $param
     * @return array
     * 获取参数的数组 {a-c}  返回 array(a,b,c)
     */
    function get_params($param){
        $name = array();

        $param = ltrim($param,'{');
        $param = rtrim($param,'}');

        $arr = explode('-',$param);

        $start = ord($arr[0]);
        $end = ord($arr[1]);

        for($i=$start;$i <= $end;$i++){
            $name[] = chr($i);
        }

        return $name;
    }

    /**
     * @param $url
     */
    function setUrls($url){
        if(is_array($url)){
            array_merge($this->caiji_urls,$url);
        }else{
            $this->caiji_urls[] = $url;
        }
    }

    /**
     * @return array
     */
    function getUrls(){
        return $this->caiji_urls;
    }

}