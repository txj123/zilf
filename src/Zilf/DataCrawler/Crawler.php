<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-2
 * Time: 上午11:09
 */

namespace Zilf\DataCrawler;


class Crawler
{
    private $rule;
    public $url;
    public $msg = array();

    function __construct($content,$rule,$url,$charset)
    {
        //彻底解决phpquery字符编码的问题
        $content = $this->_jiejue_phpquery_bug($charset,$content);
        \phpQuery::newDocumentHTML($content);
        $this->rule = $rule;
        $this->url = $url;
    }

    /**
     * @return array
     * 获取数据
     */
    function get(){
        $this->msg = array();

        $list_arr = array();

        foreach ($this->rule as $col => $row){
            $this->col = $col;

            if(is_array($row)){
                $result = $this->get_list($row);
            }else {
                $result = $this->get_con($row);
            }

            //过滤重复的数组
            if(is_array($result)){
                $result = array_unique($result);
            }

            $list_arr[$col] = $result;
        }

        return $list_arr;
    }


    //获取列表
    function get_list($row){
        $r_obj = $row['obj'];
        $r_value = $row['value'];

        //对象
        $obj = $this->get_obj($r_obj);

        //值
        $result = $this->get_obj_con($obj,$r_value);

        if($result){
            $this->_set_message(1,$this->col,$this->url,$result,'多条');
        }else{
            $this->_set_message(2,$this->col,$this->url,$result,'多条');
        }

        return $result;
    }


    /**
     * @param $r_obj
     * @param string $col
     * @return \phpQueryObject|\QueryTemplatesParse|\QueryTemplatesSource|\QueryTemplatesSourceQuery
     * 根据obj信息，获取pq的对象
     */
    function get_obj($r_obj,$col=''){
        $param_obj = explode(',',$r_obj);
        $obj = pq($param_obj[0]);
        foreach ($param_obj as $key => $find){
            $this->check_tag($find,$r_obj,$col);

            if($key == 0) continue;

            if(is_numeric($find)){
                $obj = $obj->eq($find);
            }else{
                $obj = $obj->find($find);
            }
        }

        return $obj;
    }

    /**
     * @param $list_obj
     * @param $r_value
     * @return array
     * 获取采集的内容
     */
    function get_obj_con($list_obj,$r_value){
        $list_arr = array();

        foreach ($list_obj as $obj_con){

            $p_arr = explode('->',$r_value);
            if(count($p_arr) != 2){
                die("参数：【".$obj_con.'】配置错误，必须有->分隔符');
            }

            //参数部分
            $param_value = explode(',',$p_arr[0]);
            $p_obj = pq($obj_con);
            foreach ($param_value as $key => $find){
                $this->check_tag($find,$p_arr[0]);

                $p_obj = $p_obj->find($find);
            }

            //属性部分
            $g_v = explode(':',$p_arr[1]);

            if(count($g_v) == 2){
                $g_func = $g_v[0];
                $g_par = $g_v[1];
                $href = $p_obj->$g_func($g_par);
            }else{
                $g_func = $g_v[0];
                $href = $p_obj->$g_func();
            }

            $href = trim($href);
            if(stripos($href,'http') === 0){
                $list_arr[] = $href;
            }elseif(!empty($href)){
                if(stripos($href,'/') === 0){
                    $info = parse_url($this->url);
                    $list_arr[] = $info['scheme'].'://'.$info['host'].$href;
                }else{
                    $info = pathinfo($this->url);
                    $list_arr[] = $info['dirname'].'/'.$href;
                }
            }
        }

        return $list_arr;
    }

    /**
     * @param $row
     * @param $col
     */
    function get_con($row){

        if(empty($row)) return false;

        $p_arr = explode('->',$row);
        if(count($p_arr) != 2){
            die("参数：【".$row.'】配置错误，必须有->分隔符');
        }

        //参数部分
        $param_value = explode(',',$p_arr[0]);
        $p_obj = pq($param_value[0]);
        foreach ($param_value as $key => $find){
            $this->check_tag($find,$p_arr[0]);

            if($key == 0 || empty($find)) continue;
            if(is_numeric($find)){
                $p_obj = $p_obj->eq($find);
            }else{
                $p_obj = $p_obj->find($find);
            }
        }

        //属性部分
        $g_v = explode(':',$p_arr[1]);

        if(count($g_v) == 2){
            $g_func = $g_v[0];
            $g_par = $g_v[1];
            $param = $p_obj->$g_func($g_par);
        }else{
            $g_func = $g_v[0];
            $param = $p_obj->$g_func();
        }

        if(!empty($param)){
            //过滤空格
            $param = preg_replace('/(\s+)/',' ',trim($param));

            $this->_set_message(1,$this->col,$this->url,$param);
        }else{
            $this->_set_message(2,$this->col,$this->url,$param);
        }

        return $param;
    }

    private function _set_message($type,$col='',$url='',$str='',$extra=''){
        if($type == 1){
            $style = 'style=\'color: blue;\'';
            $status = '抓取成功！';
        }elseif($type == 2){
            $style = 'style=\'color: red;\'';
            $status = '抓取失败！';
        }else{
            $style = '';
            $status = '！';
        }

        if(is_array($str)){
            $str = implode(' ; ',array_slice($str,0,3));
        }

        $msg = "<div ".$style." >".$extra." 该字段：【".$col."】 ".$status." === >>> 【".$url."】";
        $msg .= "<div style='background:#aaaaaa;color: #ffffff'>".mb_substr(strip_tags($str),0,100,'utf-8')."</div></div>";

        if(strlen($str) > 100){
            $msg .= '... ... ';
        }

        $this->msg[] = $msg;
    }

    /**
     * @param string $tag
     * 检测id，class标签是否正确，防止出错
     */
    function check_tag($tag='',$str='',$col=''){
        $tag = trim($tag);
        $html = array(
            'img','a','h1','h2','h3','h4','h5','h6','h7',
            'div','p','title','span',
            'table','tr','td','ul','li','ol',
            'textarea','radio','input','checkbox'
        );

        if(empty($tag) && $tag != 0){
            $this->msg[] = "标签：【".$tag."】，错误，为空值 ===>>> [$this->col] --- ".$str;
        }else{
            if(is_numeric($tag)){
                return true;
            }

            $num = substr_count($tag,'.');
            if($num>1 && substr_count($tag,'>') == 0){
                $this->msg[] = "标签：【".$tag."】，‘.’错误，请检测 ===>>> [$this->col] --- ".$str;
            }

            $num = substr_count($tag,'#');
            if($num>1){
                $this->msg[] = "标签：【".$tag."】，‘#’有多个，请检测 ===>>> [$this->col] --- ".$str;
            }

            if(substr_count($tag,' ') > 0 && substr_count($tag,'>') == 0){
                $this->msg[] = "标签：【".$tag."】，有空格，请检测 ===>>> [$this->col] --- ".$str;
            }

            if(substr_count($tag,'.') == 0 && substr_count($tag,'#') == 0 && substr_count($tag,':') == 0){
                if(!in_array($tag,$html)){
                    $this->msg[] = "标签：【".$tag."】，不是html标签，请检测 ===>>> [$this->col] --- ".$str;
                }
            }
        }

        return true;
    }


    /**
     * @param $charset
     * @param $content
     * @return string
     * 解决phpquery无法获取到编码的问题
     * 如果编码格式获取不到，就会出现乱码，该方法能彻底解决，但是必须要提前获取编码信息
     */
    private function _jiejue_phpquery_bug($charset,$content){

        $str = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

        //字符编码转义
        if($charset != 'utf-8'){
            $content = iconv($charset,'utf-8//IGNORE',$content);
        }

        $con = $str.$content;

        return $con;
    }
}