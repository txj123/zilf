<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-6-24
 * Time: 上午10:41
 */
require '../Client.php';
require '../CurlResponse.php';
require '../CurlException.php';


$client = new \Zilf\Curl\Client();

//echo $response->get_content();
//echo $response->get_charset();
//echo $response->get_content_type();

/*
//$client->set_httpheader([
//    'Expect:'
//]);
//或者下面的写法,其他的都支持
$client->set_httpheader = [
    'Expect:'
];

$result  = $client->get_set_httpheader();
print_r($result);
*/

//$response = $client->get('http://www.baidu.com');

//设置cookie信息
/*$client->set_open_cookie('zhuniu_login.txt');
$response = $client->post('http://www.****.com/member/login_in?random='.mt_rand(),[
    'loginName' => 'chudelong',
    'password' => 'zhuniu168',
]);*/

$client->set_open_cookie('12306.txt')
    ->set_method('get')
    ->set_Url('https://kyfw.12306.cn/otn/leftTicket/query?leftTicketDTO.train_date=2017-06-30&leftTicketDTO.from_station=SZH&leftTicketDTO.to_station=BZH&purpose_codes=ADULT');
$response = $client->exec();

print_r($client->getConfig());
print_r($response->get_content());
//print_r($response->get_all());