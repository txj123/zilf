<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-6
 * Time: 上午9:58
 */

namespace Zilf\System;

use Zilf\Db\Connection;
use Zilf\Di\Container;
use Zilf\Routing\Route;

class Application
{
    public $version = '1.0';
    public $charset = 'UTF-8';


    public $bundle = 'App';
    public $controller = 'Index';
    public $action = 'index';

    public $controller_suffix = 'Controller';
    public $action_suffix = '';
    public $view_suffix = '';

    public $params = [];
    public $segments = [];

    public $class;

    public $container;
    public $config;
    public $loader;
    public $request;

    /**
     * @var Route
     */
    public $route;

    /**
     * Application constructor.
     * @param $config //配置文件
     */
    public function __construct($config)
    {
        $this->container = Zilf::$container = new Container();
        Zilf::$app = $this;

        $this->setInit($config);

        //获取类
        $this->config = $this->container->getShare('config');
        $this->loader = $this->container->getShare('loader');
        $this->request = $this->container->getShare('request');
        $this->route = $this->container->getShare('route');

        //初始化数据库
        $params = $this->config->get('db.default');
        $this->container->set('db', 'Zilf\Db\Connection', $params);

        //初始化数据库-查询构造器
        $params = $this->config->get('db.default');
        $this->container->set('query', 'Zilf\Db\Query', $params);

        $this->setLoader();
        $this->setTimeZone();

        $this->setRoute();
    }

    /**
     * @return array
     */
    public function getClassMap($config = '')
    {
        return array(
            'config' => [
                'class' => 'Zilf\Config\Config',
                'params' => ['config'=>$config],
            ],
            'Loader' => 'Zilf\Loader\Loader',
            'curl' => 'Zilf\Curl\Curl',
            'route' => 'Zilf\Routing\Route',
            'request' => \Zilf\HttpFoundation\Request::createFromGlobals(),
            'logger' => new \Monolog\Logger('logger'),
            'log' => 'Zilf\Log\Writer',
        );
    }

    /**
     * @throws \Exception
     * 执行类
     */
    function run()
    {
        //class 必须是controller的子类
        if (!is_subclass_of($this->class, 'Zilf\System\Controller')) {
            throw new \Exception('控制器必须是Zilf\System\Controller的子类');
        }
        $this->container->get($this->class);
    }

    /**
     * 获取路由信息
     */
    public function setRoute()
    {
        $pathInfo = $this->request->getPathInfo();

        //自定义路由
        $route = $this->route;
        $routes_config = Zilf::getAppDir() . '/config/routes.php';
        require($routes_config);
        $class_exec = $route->dispatch($pathInfo);

        if ($class_exec) {
            list($pcre, $pattern, $cb, $options) = $class_exec;
            $this->class = $cb[0];
            $method = $cb[1] . $this->action_suffix;
            $params = isset($options['vars']) ? $options['vars'] : array();
        } else {
            $pathInfo = trim($pathInfo, '/');
            //获取默认的配置
            $framework = $this->config->get('framework');
            if (!empty($framework)) {
                foreach ($framework as $key => $value) {
                    if ($value) {
                        $this->$key = $value;
                    }
                }
            }

            //设置路由
            if ($pathInfo) {
                $this->segments = explode('/', $pathInfo);

                $this->getBundle();
                $this->getController();
                $this->getAction();
                $this->getParams();
            }

            $this->class = ucfirst($this->bundle) . '\\Controllers\\' . ucfirst($this->controller) . $this->controller_suffix;
            $method = $this->action . $this->action_suffix;
            $params = $this->params;
        }

        $this->container->set($this->class, $this->class, $params);
        $this->container->setMethod($this->class, $method);
    }

    /**
     * 根据url,获取当前包的名称
     */
    function getBundle()
    {
        $segment = isset($this->segments[0]) ? $this->segments[0] : '';
        $segment = strtolower($segment);

        if (!empty($segment)) {
            $bundles = $this->config->get('bundles');

            if (!empty($bundles[$segment])) {
                $this->bundle = ucfirst($segment);
                //移除bundel
                array_shift($this->segments);
            }
        }
    }

    /**
     * @return mixed|string
     * 获取控制器
     */
    function getController()
    {
        if (!empty($this->segments)) {
            $this->controller = array_shift($this->segments);
        }
    }

    /**
     * @return mixed|string
     * 获取方法
     */
    function getAction()
    {
        if (!empty($this->segments)) {
            $this->action = array_shift($this->segments);
        }
    }

    /**
     * 获取参数
     */
    function getParams()
    {
        $this->params = $this->segments;
    }

    public function getDb()
    {
        return $this->container->get('db');
    }

    /**
     * 初始化配置
     */
    function setInit($config='')
    {
        //初始化类
        if ($classMap = $this->getClassMap($config)) {

            foreach ($classMap as $id => $item) {
                if (is_array($item)) {
                    $class = $item['class'];
                    $params = isset($item['params']) && !empty($item['params']) ? $item['params'] : [];

                } else {
                    $class = $item;
                    $params = [];
                }

                $this->container->set($id, $class, $params);
            }
        }


    }


    /**
     * 加载bundles
     */
    function setLoader()
    {
        $this->loader->registerBundle(
            $this->container->get('config')->get('bundles')
        );

        $this->loader->registerDir(
            array(//'' //文件夹路径    加载类
            )
        );

        $this->loader->register();
    }


    /**
     * 设置时区
     */
    public function setTimeZone()
    {
        //设置时区
        $timezone = $this->config->get('timezone');

        if (!empty($timezone)) {
            date_default_timezone_set($timezone);
            $this->config->offsetUnset('timeZone');  //释放内存

        } elseif (!ini_get('date.timezone')) {
            date_default_timezone_set('UTC');
        }
    }

    /**
     * 获取当前的时区
     * @return string
     */
    public function getTimeZone()
    {
        return date_default_timezone_get();
    }

    /**
     * @return string
     */
    public function getRuntime()
    {
        $runtime = Zilf::$container->get('config')->get('runtime');
        if (empty($runtime)) {
            $runtime = APP_PATH . '/runtime';
        }
        return $runtime;
    }
}