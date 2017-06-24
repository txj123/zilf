<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-6-24
 * Time: 下午3:21
 */

include '../Client.php';
include '../CurlResponse.php';
include '../CurlException.php';


$client = new \Zilf\Curl\Client();

$result = $client->requestAsync('get',['http://www.baidu.com','http://www.zhuniu.com']);

foreach ($result as $row){
     print_r($row->get_content());
     print_r($row->get_info());
}