<?php

if (!function_exists('cookie')) {
    /**
     * Cookie 设置、获取、删除
     * @param string $name cookie名称
     * @param mixed $value cookie值
     * @param mixed $option cookie参数
     * @return mixed
     */
    function cookie($name = '', $value = '', $option = null)
    {
        return cookie_helper($name,$value,$option);
    }
}

if (!function_exists('cookie_helper')) {
    /**
     * Cookie 设置、获取、删除
     * @param string $name cookie名称
     * @param mixed $value cookie值
     * @param mixed $option cookie参数
     * @return mixed
     */
    function cookie_helper($name = '', $value = '', $option = null)
    {
        // 默认设置
        $cookie = \Zilf\System\Zilf::$container->getShare('config')->get('cookie');
        $config = array(
            'prefix' => $cookie['cookie_prefix'], // cookie 名称前缀
            'expire' => $cookie['cookie_expire'], // cookie 保存时间
            'path' => $cookie['cookie_path'], // cookie 保存路径
            'domain' => $cookie['cookie_domain'], // cookie 有效域名
            'secure' => $cookie['cookie_secure'], //  cookie 启用安全传输
            'httponly' => $cookie['cookie_httponly'], // httponly设置
        );
        // 参数设置(会覆盖黙认设置)
        if (!is_null($option)) {
            if (is_numeric($option))
                $option = array('expire' => $option);
            elseif (is_string($option))
                parse_str($option, $option);
            $config = array_merge($config, array_change_key_case($option));
        }
        if (!empty($config['httponly'])) {
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
                        setcookie($key, '', time() - 3600, $config['path'], $config['domain'], $config['secure'], $config['httponly']);
                        unset($_COOKIE[$key]);
                    }
                }
            }
            return null;
        } elseif ('' === $name) {
            // 获取全部的cookie
            return $_COOKIE;
        }
        $name = $config['prefix'] . str_replace('.', '_', $name);
        if ('' === $value) {
            if (isset($_COOKIE[$name])) {
                $value = $_COOKIE[$name];
                if (0 === strpos($value, 'think:')) {
                    $value = substr($value, 6);
                    return array_map('urldecode', json_decode(MAGIC_QUOTES_GPC ? stripslashes($value) : $value, true));
                } else {
                    return $value;
                }
            } else {
                return null;
            }
        } else {
            if (is_null($value)) {
                setcookie($name, '', time() - 3600, $config['path'], $config['domain'], $config['secure'], $config['httponly']);
                unset($_COOKIE[$name]); // 删除指定cookie
            } else {
                // 设置cookie
                if (is_array($value)) {
                    $value = 'think:' . json_encode(array_map('urlencode', $value));
                }
                $expire = !empty($config['expire']) ? time() + intval($config['expire']) : 0;
                setcookie($name, $value, $expire, $config['path'], $config['domain'], $config['secure'], $config['httponly']);
                $_COOKIE[$name] = $value;
            }
        }
        return null;
    }
}

if (!function_exists('config_helper')) {
    /**
     * 获取配置信息
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    function config_helper($name, $default = null)
    {
        return \Zilf\System\Zilf::$container->getShare('config')->get($name, $default);
    }
}

if (!function_exists('config')) {
    /**
     * 获取配置信息
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    function config($name, $default = null)
    {
        return config_helper($name,$default);
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
        return \Zilf\Helpers\Url::current_url();
    }
}

if (!function_exists('route_info')) {
    /**
     * 获取当前的url
     *
     * @param string $key
     * @return string
     */
    function route_info($key)
    {
        return \Zilf\Helpers\Url::routeInfo($key);
    }
}

////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('toRoute')) {
    /**
     * 例子
     * toRoute('path/show');  # http://www.xx.com/currentBundle/path/show
     *
     * @param string $url
     * @param string $params
     * @param bool $scheme
     * @return string
     */
    function toRoute($url = '', $params = '', $scheme = true)
    {
        return \Zilf\Helpers\Url::toRoute($url, $params, $scheme);
    }
}

////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('str_limit')) {
    /**
     * Limit the number of characters in a string.
     *
     * @param  string $value
     * @param  int $limit
     * @param  string $end
     * @return string
     */
    function str_limit($value, $limit = 100, $end = '...')
    {
        return \Zilf\Helpers\Str::limit($value, $limit, $end);
    }
}


if (!function_exists('tap')) {
    /**
     * Call the given Closure with the given value then return the value.
     *
     * @param  mixed $value
     * @param  callable $callback
     * @return mixed
     */
    function tap($value, $callback)
    {
        $callback($value);

        return $value;
    }
}


if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if (!function_exists('windows_os')) {
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


if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  \ArrayAccess|array $array
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return \Zilf\Helpers\Arr::get($array, $key, $default);
    }
}

if (!function_exists('array_has')) {
    /**
     * Check if an item or items exist in an array using "dot" notation.
     *
     * @param  \ArrayAccess|array $array
     * @param  string|array $keys
     * @return bool
     */
    function array_has($array, $keys)
    {
        return \Zilf\Helpers\Arr::has($array, $keys);
    }
}

if (! function_exists('e')) {
    /**
     * Escape HTML special characters in a string.
     *
     * @param  string  $value
     * @return string
     */
    function e($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
}

if (! function_exists('last')) {
    /**
     * Get the last element from an array.
     *
     * @param  array  $array
     * @return mixed
     */
    function last($array)
    {
        return end($array);
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
        $hashId = \Zilf\System\Zilf::$container->get('hashids');
        $arr = $hashId->decode($hash);
        if (!empty($arr)) {
            return count($arr) == 1 ? $arr[0] : $arr;
        } else {
            return null;
        }
    }
}

////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('password_make')) {
    /**
     * Hash the given value.
     *
     * @param  string $value
     * @param  array $options
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
     * @param  string $value
     * @param  string $hashedValue
     * @param  array $options
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

////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('html_encode')) {
    /**
     * @param $content
     * @param bool $doubleEncode
     * @return string
     */
    function html_encode($content, $doubleEncode = true){
        return \Zilf\Helpers\Html::encode($content, $doubleEncode);
    }
}

if (!function_exists('html_decode')) {
    /**
     * @param $content
     * @return string
     */
    function html_decode($content){
        return \Zilf\Helpers\Html::decode($content);
    }
}

if (!function_exists('asset_link')) {
    /**
     * @param $url
     * @param string $version
     * @param string $urlName
     * @return string
     */
    function asset_link($url, $version = '', $urlName = 'default'){
        return \Zilf\Helpers\Url::assetUrl($url,$version,$urlName);
    }
}

if (!function_exists('asset_css')) {
    /**
     * @param $url
     * @param array $options
     * @param string $urlName
     * @return string
     */
    function asset_css($url, $options = [], $urlName = 'default'){
        return \Zilf\Helpers\Html::assetCss($url, $options, $urlName);
    }
}

if (!function_exists('asset_js')) {
    /**
     * @param $url
     * @param array $options
     * @param string $urlName
     * @return string
     */
    function asset_js($url, $options = [], $urlName = 'default'){
        return \Zilf\Helpers\Html::assetJs($url, $options, $urlName);
    }
}

if (!function_exists('asset_img')) {
    /**
     * @param $url
     * @param array $options
     * @param string $urlName
     * @return string
     */
    function asset_img($url, $options = [], $urlName = 'default'){
        return \Zilf\Helpers\Html::assetImg($url, $options, $urlName);
    }
}

if (!function_exists('asset_a')) {
    /**
     * @param $text
     * @param null $url
     * @param array $options
     * @return string
     */
    function asset_a($text, $url = null, $options = []){
        return \Zilf\Helpers\Html::a($text, $url, $options);
    }
}

if (!function_exists('asset_mailto')) {
    /**
     * @param $text
     * @param null $email
     * @param array $options
     * @return string
     */
    function asset_mailto($text, $email = null, $options = []){
        return \Zilf\Helpers\Html::assetImg($text, $email, $options);
    }
}