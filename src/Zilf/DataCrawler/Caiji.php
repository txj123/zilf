<?php
/**
 * Created by PhpStorm.
 * User: fendou
 * Date: 16-8-17
 * Time: 上午11:48
 */

namespace Zilf\DataCrawler;

/**
 * Class Caiji
 * @package Zilf\DataCrawler
 *
 * 参数配置参考事例
    $config = array(
            'list' => array(
                    'url' => 'http://www.31expo.com/1-26/1.html',
                    'curl' => array(
                    'type' => 'get',   //请求方式
                    'params' => array(),  //请求参数
                    'options' => array(
                    'cookie_file' => '/tmp/cookie_login.txt',
                    'referer' => '',
                ),
            ),
            'rule' => array(
                    'test' => 'title->text',
                    'url' => array(
                    'obj' => '.cle,table,.huikuai2',
                    'value' => 'a:first->attr:href'
                ),
            ),
            'func' => array(),
        ),
        'content' => array(
                'url' => '@url',  //'@'标识使用上级采集的数据
                'rule' => array(
                'title' => 'title->text'
            )
        )
    );
 */

class Caiji
{
    static $table;
    static $config;
    static $extra;
    private $func;

    public $msg = array();

    static function instance($config,$extra=array()){
        self::$config = $config;
        self::$extra = $extra;
        return new Caiji();
    }

    public function get(){

        $config_arr = self::$config;
        $client = new Client();

        //初始化数组为索引数组
        $config_arr = array_values($config_arr);
        $list_arr = array();

        foreach ($config_arr as $key=>$config){

            //过滤的函数信息
            $this->func = isset($config['func']) ? $config['func'] : '';

            //需要保存的数据表信息
            self::$table = isset($config['table']) ? $config['table'] : '';

            //字符编码
            $charset = isset($config['charset']) ? $config['charset'] : '';

            //Curl 对象的配置信息
            $curl_config = isset($config['curl']) ? $config['curl'] : '';


            if($key == 0){
                $list_arr = $client->request($config['url'],$config['rule'],$curl_config,$charset)->exec();
            }else{
                if(substr_count($config['url'],'@') == 1){
                    $urls = $this->_get_all_urls($list_arr,substr($config['url'],1));

                    foreach ($urls as $row){
                        if($this->_is_exists(self::$table,$row)){
                            $this->msg[] = array("<div style='color: gold;'>该网址：【".$row."】已经采集过了！\n<br/></div>");
                            continue;
                        }
                        $lists = $client->request($row,$config['rule'],$curl_config,$charset)->exec();
                        $list_arr = array_merge($list_arr,$lists);
                    }
                }else{
                    $lists = $client->request($config['url'],$config['rule'],$curl_config,$charset)->exec();
                    $list_arr = array_merge($list_arr,$lists);
                }
            }
        }

        $this->msg = array_merge($this->msg,$client->msg);

        return $list_arr;
    }

    /**
     * @param array $arr
     * @param string $key
     * @return array
     */
    private function _get_all_urls($arr=array(),$key='url'){
        $urls = array();
        foreach ($arr as $value){
            if($value){
                $urls = array_merge($urls,$value[$key]);
            }
        }

        return $urls;
    }

    /**
     * @param $data
     * @param $obj
     * @return array
     * 过滤数据
     */
    public function filter_data($data,$obj){
        $arr = array();
        $func = self::$config['content']['func'];

        foreach ($data as $row){
            //通过函数过滤特殊字符
            foreach ($row as $col => $item){
                if(isset($func[$col]) && !empty($func[$col])){
                    $func = $func[$col];
                    $row[$col] = $obj->$func($item);
                }
            }

            if(isset($row['_extra'])){
                foreach ($row['_extra'] as $c_k => $c_v){
                    $row[$c_k] = $c_v;
                }
            }

            $row['url'] = $row['_url'];
            $row['md5_url'] = $row['_md5_url'];
            $row['add_time'] = $row['_add_time'];

            unset($row['_url']);
            unset($row['_md5_url']);
            unset($row['_add_time']);
            unset($row['_extra']);

            $arr[] = $row;
        }

        return $arr;
    }

    public function show_logs(){
        $msg = $this->msg;
        echo "<hr/> 采集日志：=========  <br/>";
        echo '<div style="background: #dca7a7">';

        if(!empty($msg)){
            foreach ($msg as $row){
                if(is_array($row)){
                    foreach ($row as $v){
                        echo $v;
                    }
                }else{
                    echo $row;
                }
                echo "<hr/>";
            }
        }

        echo "</div>";
    }

    private function _is_exists($table,$url){
//        if(function_exists(M)){
//            $is_exist = M($table)->where(array('md5_url'=>md5($url)))->count();
//            return $is_exist ? true : false;
//        }
    }
}