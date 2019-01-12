<?php

namespace Zilf\Routing\Dispatch;

use think\exception\HttpException;
use think\Loader;
use Zilf\Facades\Request;
use Zilf\Routing\Dispatch;

class Url extends Dispatch
{
    public function init()
    {
        // 解析默认的URL规则
        return $this->parseUrl($this->dispatch);

//        return (new Module($this->rule, $result))->init();
    }

    public function exec()
    {
    }

    /**
     * 解析URL地址
     * @access protected
     * @param  string $url URL
     * @return array
     */
    protected function parseUrl($url)
    {
        $depr = $this->rule->getConfig('app.pathinfo_depr');
        $bind = $this->rule->getRouter()->getBind();

        if (!empty($bind) && preg_match('/^[a-z]/is', $bind)) {
            $bind = str_replace('/', $depr, $bind);
            // 如果有模块/控制器绑定
            $url = $bind . ('.' != substr($bind, -1) ? $depr : '') . ltrim($url, $depr);
        }

        list($path, $var) = $this->rule->parseUrlPath($url);

        return $path;

//        // 解析模块
//        $module = array_shift($path);
//
//        if ($this->param['auto_search']) {
//            $controller = $this->autoFindController($module, $path);
//        } else {
//            // 解析控制器
//            $controller = !empty($path) ? array_shift($path) : null;
//        }
//
//        // 解析操作
//        $action = !empty($path) ? array_shift($path) : null;
//
//        // 解析额外参数
//        if ($path) {
//            if ($this->rule->getConfig('url_param_type')) {
//                $var += $path;
//            } else {
//                preg_replace_callback('/(\w+)\|([^\|]+)/', function ($match) use (&$var) {
//                    $var[$match[1]] = strip_tags($match[2]);
//                }, implode('|', $path));
//            }
//        }
//
//        $panDomain = Request::panDomain();
//
//        if ($panDomain && $key = array_search('*', $var)) {
//            // 泛域名赋值
//            $var[$key] = $panDomain;
//        }
//
//        // 设置当前请求的参数
//        Request::setRouteVars($var);
//
//        // 封装路由
//        $route = [$module, $controller, $action];
//
//        if ($this->hasDefinedRoute($route, $bind)) {
//            throw new HttpException(404, 'invalid request:' . str_replace('|', $depr, $url));
//        }
//
//        return $route;
    }

    /**
     * 检查URL是否已经定义过路由
     * @access protected
     * @param  string $route 路由信息
     * @param  string $bind 绑定信息
     * @return bool
     */
    protected function hasDefinedRoute($route, $bind)
    {
        list($module, $controller, $action) = $route;

        // 检查地址是否被定义过路由
        $name = strtolower($module . '/' . $controller . '/' . $action);

        $name2 = '';

        if (empty($module) || $module == $bind) {
            $name2 = strtolower($controller . '/' . $action);
        }

        $host = Request::getHost();

        $method = Request::getMethod();

        if ($this->rule->getRouter()->getName($name, $host, $method) || $this->rule->getRouter()->getName($name2, $host, $method)) {
            return true;
        }

        return false;
    }

    /**
     * 自动定位控制器类
     * @access protected
     * @param  string $module 模块名
     * @param  array $path URL
     * @return string
     */
    protected function autoFindController($module, &$path)
    {
        $dir = $this->app->getAppPath() . ($module ? $module . '/' : '') . $this->rule->getConfig('url_controller_layer');
        $suffix = $this->app->getSuffix() || $this->rule->getConfig('controller_suffix') ? ucfirst($this->rule->getConfig('url_controller_layer')) : '';

        $item = [];
        $find = false;

        foreach ($path as $val) {
            $item[] = $val;
            $file = $dir . '/' . str_replace('.', '/', $val) . $suffix . '.php';
            $file = pathinfo($file, PATHINFO_DIRNAME) . '/' . Loader::parseName(pathinfo($file, PATHINFO_FILENAME), 1) . '.php';
            if (is_file($file)) {
                $find = true;
                break;
            } else {
                $dir .= '/' . Loader::parseName($val);
            }
        }

        if ($find) {
            $controller = implode('.', $item);
            $path = array_slice($path, count($item));
        } else {
            $controller = array_shift($path);
        }

        return $controller;
    }

}
