<?php
namespace Zilf\Helpers;

use Zilf\Facades\Request;
use Zilf\System\Zilf;


class Url
{
    public static function toRoute($url = '', $params = '',$scheme = true){
        $bundle = Zilf::$app->bundle;

        if (strncmp($url, '//', 2) === 0) {
            // e.g. //hostname/path/to/resource
            return is_string($scheme) ? "$scheme:$url" : $url;
        }elseif (strncmp($url, '/', 1) === 0){
            // e.g. /path/to/resource
            $url = ltrim($url,'/');
            $bundle = '';
        }

        if($scheme){
            $host = Request::getSchemeAndHttpHost();
        }else{
            $host = '';
        }

        $url = $host.'/' . ($bundle ? strtolower($bundle) .'/' : '') . $url;
        if (is_string($scheme) && ($pos = strpos($url, '://')) !== false) {
            $url = $scheme . substr($url, $pos);
        }

        $str_param = '';
        if(is_array($params) && !empty($params)){
            $str_param = '/'.implode('/',$params);
        }elseif(!empty($params)){
            $str_param = '/'.(string)$params;
        }

        return $url.$str_param;
    }

    /**
     * @return string
     */
    public static function current_url()
    {
        return Request::fullUrl();
    }
}
