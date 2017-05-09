<?php

if(!function_exists('cookie_helper')){
    /**
     * Cookie 设置、获取、删除
     * @param string $name cookie名称
     * @param mixed $value cookie值
     * @param mixed $option cookie参数
     * @return mixed
     */
    function cookie_helper($name='', $value='', $option=null) {
        // 默认设置
        $cookie = \Zilf\System\Zilf::$container->getShare('config')->get('cookie');
        $config = array(
            'prefix'    =>  $cookie['cookie_prefix'], // cookie 名称前缀
            'expire'    =>  $cookie['cookie_expire'], // cookie 保存时间
            'path'      =>  $cookie['cookie_path'], // cookie 保存路径
            'domain'    =>  $cookie['cookie_domain'], // cookie 有效域名
            'secure'    =>  $cookie['cookie_secure'], //  cookie 启用安全传输
            'httponly'  =>  $cookie['cookie_httponly'], // httponly设置
        );
        // 参数设置(会覆盖黙认设置)
        if (!is_null($option)) {
            if (is_numeric($option))
                $option = array('expire' => $option);
            elseif (is_string($option))
                parse_str($option, $option);
            $config     = array_merge($config, array_change_key_case($option));
        }
        if(!empty($config['httponly'])){
            ini_set("session.cookie_httponly", 1);
        }
        // 清除指定前缀的所有cookie
        if (is_null($name)) {
            if (empty($_COOKIE))
                return null;
            // 要删除的cookie前缀，不指定则删除config设置的指定前缀
            $prefix = empty($value) ? $config['prefix'] : $value;
            if (!empty($prefix)) {// 如果前缀为空字符串将不作处理直接返回
                foreach ($_COOKIE as $key => $val) {
                    if (0 === stripos($key, $prefix)) {
                        setcookie($key, '', time() - 3600, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
                        unset($_COOKIE[$key]);
                    }
                }
            }
            return null;
        }elseif('' === $name){
            // 获取全部的cookie
            return $_COOKIE;
        }
        $name = $config['prefix'] . str_replace('.', '_', $name);
        if ('' === $value) {
            if(isset($_COOKIE[$name])){
                $value =    $_COOKIE[$name];
                if(0===strpos($value,'think:')){
                    $value  =   substr($value,6);
                    return array_map('urldecode',json_decode(MAGIC_QUOTES_GPC?stripslashes($value):$value,true));
                }else{
                    return $value;
                }
            }else{
                return null;
            }
        } else {
            if (is_null($value)) {
                setcookie($name, '', time() - 3600, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
                unset($_COOKIE[$name]); // 删除指定cookie
            } else {
                // 设置cookie
                if(is_array($value)){
                    $value  = 'think:'.json_encode(array_map('urlencode',$value));
                }
                $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
                setcookie($name, $value, $expire, $config['path'], $config['domain'],$config['secure'],$config['httponly']);
                $_COOKIE[$name] = $value;
            }
        }
        return null;
    }
}

if(!function_exists('config_helper')){
    /**
     * 获取配置信息
     *
     * @param $name
     * @return $this
     */
    function config_helper($name){
        return \Zilf\System\Zilf::$container->getShare('config')->get($name);
    }
}

if (!function_exists('current_url')) {
    /**
     * 获取当前的url
     *
     * @return string
     */
    function current_url()
    {
        return \Zilf\Facades\Request::fullUrl();
    }
}

////////////////////////////////////////////////////////////////////////////////////

if(!function_exists('toRoute')){
    /**
     * 例子
     * toRoute('path/show');  # http://www.xx.com/currentBundle/path/show
     *
     * @param string $url
     * @param string $params
     * @param bool $scheme
     * @return string
     */
    function toRoute($url = '', $params = '',$scheme = true){
        $bundle = \Zilf\System\Zilf::$app->bundle;

        if (strncmp($url, '//', 2) === 0) {
            // e.g. //hostname/path/to/resource
            return is_string($scheme) ? "$scheme:$url" : $url;
        }elseif (strncmp($url, '/', 1) === 0){
            // e.g. /path/to/resource
            $url = ltrim($url,'/');
            $bundle = '';
        }

        if($scheme){
            $host = \Zilf\Facades\Request::getSchemeAndHttpHost();
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
}

////////////////////////////////////////////////////////////////////////////////////

if (! function_exists('str_limit')) {
    /**
     * Limit the number of characters in a string.
     *
     * @param  string  $value
     * @param  int     $limit
     * @param  string  $end
     * @return string
     */
    function str_limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
    }
}


if (! function_exists('tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param  mixed  $value
     * @param  callable  $callback
     * @return mixed
     */
    function tap($value, $callback)
    {
        $callback($value);

        return $value;
    }
}


if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (! function_exists('windows_os')) {
    /**
     * Determine whether the current environment is Windows based.
     *
     * @return bool
     */
    function windows_os()
    {
        return strtolower(substr(PHP_OS, 0, 3)) === 'win';
    }
}


if (! function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return \Zilf\Support\Arr::get($array, $key, $default);
    }
}

if (! function_exists('array_has')) {
    /**
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param  \ArrayAccess|array  $array
     * @param  string|array  $keys
     * @return bool
     */
    function array_has($array, $keys)
    {
        return \Zilf\Support\Arr::has($array, $keys);
    }
}

//////////////////////////////////////////////

if (!function_exists('hashids_encode')) {
    /**
     * id 参数的数据加密
     *
     * @param array ...$args
     * @return mixed
     */
    function hashids_encode(...$args)
    {
        /**
         * @var $hashid \Zilf\Security\Hashids\Hashids
         */
        $hashid = \Zilf\System\Zilf::$container->get('hashids');
        return $hashid->encode($args);
    }
}

if (!function_exists('hashids_decode')) {
    /**
     * @param $hash
     * @return mixed
     */
    function hashids_decode($hash)
    {
        /**
         * @var $hashid \Zilf\Security\Hashids\Hashids
         */
        $hashid = \Zilf\System\Zilf::$container->get('hashids');
        $arr = $hashid->decode($hash);
        if(!empty($arr)){
            return count($arr) == 1 ? $arr[0] : $arr;
        }else{
            return null;
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('password_make')) {
    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     *
     * @throws \RuntimeException
     */
    function password_make($value, array $options = [])
    {
        /**
         * @var $hashing \Zilf\Security\Hashing\PasswordHashing
         */
        $hashing = \Zilf\System\Zilf::$container->get('hashing');
        return $hashing->make($value, $options);
    }
}

if (!function_exists('password_check')) {
    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    function password_check($value, $hashedValue, array $options = [])
    {
        /**
         * @var $hashing \Zilf\Security\Hashing\PasswordHashing
         */
        $hashing = \Zilf\System\Zilf::$container->get('hashing');
        return $hashing->check($value, $hashedValue, $options);
    }
}

