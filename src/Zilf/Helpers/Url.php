<?php

namespace Zilf\Helpers;

use Zilf\Facades\Request;
use Zilf\System\Zilf;


class Url
{
    public static function assetUrl($url, $version='', $urlName = 'default')
    {
        //获取设置的url信息，如果不存在，则使用当前默认地址
        $staticUrl = config('assets.' . $urlName, Request::getSchemeAndHttpHost());

        $strVersion = (stripos($url,'?') == 0) ? $version ? '?'.$version : '' : '&'.$version;

        if (strncmp($url, '//', 2) === 0) {
            return $url.$strVersion;
        } else {
            return $staticUrl . '/' . ltrim($url, '/').$strVersion;
        }
    }

    /**
     * @param string $url
     * @param string $params
     * @param bool $scheme
     * @return string
     */
    public static function toRoute($url = '', $params = '', $scheme = true)
    {
        $bundle = Zilf::$app->bundle;

        if (strncmp($url, '//', 2) === 0) {
            // e.g. //hostname/path/to/resource
            return is_string($scheme) ? "$scheme:$url" : $url;
        } elseif (strncmp($url, '/', 1) === 0) {
            // e.g. /path/to/resource
            $url = ltrim($url, '/');
            $bundle = '';
        }

        if ($scheme) {
            $host = Request::getSchemeAndHttpHost();
        } else {
            $host = '';
        }

        $url = $host . '/' . ($bundle ? strtolower($bundle) . '/' : '') . $url;
        if (is_string($scheme) && ($pos = strpos($url, '://')) !== false) {
            $url = $scheme . substr($url, $pos);
        }

        $str_param = '';
        if (is_array($params) && !empty($params)) {
            $str_param = '/' . implode('/', $params);
        } elseif (!empty($params)) {
            $str_param = '/' . (string)$params;
        }

        return $url . $str_param;
    }

    /**
     * @return string
     */
    public static function current_url()
    {
        return Request::fullUrl();
    }
}
