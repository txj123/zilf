<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-6
 * Time: 上午9:58
 */

namespace Zilf\System;

use Zilf\ClassLoader\ClassMapGenerator;
use Zilf\ClassLoader\MapClassLoader;
use Zilf\Db\Connection;
use Zilf\Di\Container;
use Zilf\Exceptions\HandleExceptions;
use Zilf\Exceptions\NotFoundHttpException;
use Zilf\HttpFoundation\Response;
use Zilf\Routing\Route;

class Application
{
    public $charset = 'UTF-8';

    public $bundle = 'Http';      //http请求的bundle的名称
    public $controller = 'Index'; //http请求的类的名称
    public $action = 'index';    //http请求的类的方法名称
    public $params = [];        //http请求的参数信息，注：非get,post的参数，是url如：/aa/bb/cc/dd/ee中获取的参数

    public $controller_suffix = 'Controller';
    public $action_suffix = '';
    public $view_suffix = '';


    public $segments = [];
    public $request;

    public $environment;  //开发环境
    /**
     * @var Route
     */
    public $route;

    public $database = 'default';

    /**
     * Application constructor.
     * @param $environment //配置文件
     */
    public function __construct($environment)
    {
        Zilf::$container = new Container();
        Zilf::$app = $this;
        $this->environment = $environment;

        //注册服务
        new Services();

        //加载或缓存app目录下的类的列表
        $this->loadClassMap();

        //设置时区
        $this->setTimeZone();

        //设置异常信息
        $this->setHandler();

        //加载路由库
        if (PHP_SAPI !== 'cli') {
            $pathInfo = Zilf::$container['request']->getPathInfo();
            $this->setRoute($pathInfo);
        } else {
            $argv = $_SERVER['argv'];
            $this->setRoute(isset($argv[1]) ? $argv[1] : '');

            $argc = $_SERVER['argc'];
            if ($argc > 2) {
                $this->params = array_slice($argv, 2);
            }
            unset($argc);
            unset($argv);
        }

        //加载服务信息
        $services = APP_PATH . '/config/services.php';
        if (file_exists($services)) {
            require_once($services);
        }

        //初始化数据库
        $params = Zilf::$container->getShare('config')->get('db');
        foreach ($params as $key => $row) {
            Zilf::$container->register($key, 'Zilf\Db\Connection', $row);
        }
    }

    /**
     * 执行类
     *
     * @throws \Exception
     */
    function run()
    {
        $class = ucfirst($this->bundle) . '\\Controllers\\' . ucfirst($this->controller) . $this->controller_suffix;
        if (!class_exists($class)) {
            $message = sprintf('No route found for "%s %s"', Zilf::$container['request']->getMethod(), Zilf::$container['request']->getPathInfo());

            if ($referer = Zilf::$container['request']->headers->get('referer')) {
                $message .= sprintf(' (from "%s")', $referer);
            }
            throw new NotFoundHttpException($message);
        }

        $object = Zilf::$container->build($class, []);
        if (method_exists($object, $this->action)) {
            //class 必须是controller的子类
            /*  if (!is_subclass_of($this->class, 'Zilf\System\Controller')) {
                throw new \Exception('控制器必须是继承Zilf\System\Controller类');
            }*/

            //将参数追加到GET里面
            if (!empty($this->params)) {
                foreach ($this->params as $key => $row) {
                    if ($row === '') {
                    } else {
                        $_GET['zget' . $key] = $row;
                    }
                }
                Zilf::$container->get('request')->query->add($_GET);
            }

            $response = call_user_func_array(array($object, $this->action), $this->params);
            if (!$response instanceof Response) {
                $msg = sprintf('The controller must return a response (%s given).', $this->varToString($response));

                // the user may have forgotten to return something
                if (null === $response) {
                    $msg .= ' Did you forget to add a return statement somewhere in your controller?';
                }
                throw new \LogicException($msg);
            }
            $response->send();
        } else {
            throw new \Exception('类: ' . $class . ' 调用的方法：' . $this->action . ' 不存在！');
        }
    }

    private function varToString($var)
    {
        if (is_object($var)) {
            return sprintf('Object(%s)', get_class($var));
        }

        if (is_array($var)) {
            $a = array();
            foreach ($var as $k => $v) {
                $a[] = sprintf('%s => %s', $k, $this->varToString($v));
            }

            return sprintf('Array(%s)', implode(', ', $a));
        }

        if (is_resource($var)) {
            return sprintf('Resource(%s)', get_resource_type($var));
        }

        if (null === $var) {
            return 'null';
        }

        if (false === $var) {
            return 'false';
        }

        if (true === $var) {
            return 'true';
        }

        return (string)$var;
    }

    /**
     * 获取路由信息
     */
    public function setRoute($pathInfo = '')
    {
        //自定义路由
        $route = Zilf::$container->get('route');
        $routes_config = APP_PATH . '/config/routes.php';
        if (file_exists($routes_config)) {
            //加载路由的配置文件
            include_once $routes_config;

            $class_exec = $route->dispatch($pathInfo);
            if ($class_exec) {
                list($pcre, $pattern, $cb, $options) = $class_exec;
                $this->controller = $cb[0];
                $this->action = $cb[1] . $this->action_suffix;
                $this->params = isset($options['vars']) ? $options['vars'] : array();

            } else {
                $pathInfo = trim($pathInfo, '/');
                //获取默认的配置
                $framework = Zilf::$container->getShare('config')->get('framework');
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
            }
        }
    }


    /**
     * 根据url,获取当前包的名称
     */
    function getBundle()
    {
        $segment = isset($this->segments[0]) ? $this->segments[0] : '';
        $segment = strtolower($segment);

        if (!empty($segment)) {
            $bundles = Zilf::$container->getShare('config')->get('bundles');
            if (isset($bundles[$segment])) {
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
        unset($this->segments);
    }

    /**
     * 支持db，获取数据库对象
     * @return Connection
     */
    public function getDb($databaseName = '')
    {
        return Zilf::$container->get($this->database);
    }

    public function setDb($databaseName)
    {
        $this->database = $databaseName;
    }

    /**
     * 加载app目录下面的类的文件，优化加载速度，提高效率
     * 开发模式下 class_map.php 每次都会重新生成
     *
     * @throws \Exception
     */
    public function loadClassMap()
    {
        $runtime = $this->getRuntime();
        //判断文件夹是否存在
        if (file_exists($runtime) && is_dir($runtime)) {
            if (!is_writable($runtime)) {
                throw new \Exception('目录：' . $runtime . '不可写，请增加写的权限！');
            }
        } else {
            @mkdir($runtime, 0777, true);
            if(!is_dir($runtime)){
                throw new \Exception('目录：' . $runtime . '无权限创建，请手动创建！');
            }
        }

        //注册
        $file = $runtime . DIRECTORY_SEPARATOR . 'class_map.php';
        if (!file_exists($file) || Zilf::$app->getEnvironment() == 'dev') {
            //写入类的地图信息
            ClassMapGenerator::dump(APP_PATH . DIRECTORY_SEPARATOR . 'app', $file);
        }

        $mapping = require_once $file;
        $loader = new MapClassLoader($mapping);
        $loader->register();
    }

    /**
     * 获取缓存文件夹的路径
     * @return string
     */
    public function getRuntime()
    {
        $runtime = Zilf::$container->getShare('config')->get('runtime');
        if (empty($runtime)) {
            $runtime = APP_PATH . DIRECTORY_SEPARATOR . 'runtime';
        }
        return $runtime;
    }

    /**
     * 设置时区
     */
    public function setTimeZone()
    {
        //设置时区
        $timezone = Zilf::$container->getShare('config')->get('timezone');

        if (!empty($timezone)) {
            date_default_timezone_set($timezone);
            Zilf::$container->getShare('config')->offsetUnset('timeZone');  //释放内存
        } elseif (!ini_get('date.timezone')) {
            date_default_timezone_set('UTC');
        }
    }

    /**
     * 获取当前的时区
     *
     * @return string
     */
    public function getTimeZone()
    {
        return date_default_timezone_get();
    }

    /**
     *
     */
    private function setHandler()
    {
        $handle = new HandleExceptions();
        $handle->bootstrap();

        switch ($this->environment) {
            case 'dev':
            case 'development':
                ini_set('display_errors', 1);
                break;

            case 'testing':
            case 'pro':
            case 'prod':
            case 'production':
                ini_set('display_errors', 0);
                break;

            default:
                header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
                echo 'The application environment is not set correctly.';
                exit(1); // EXIT_ERROR
        }
    }

    /**
     * Determine if we are running in the console.
     *
     * @return bool
     */
    public function runningInConsole()
    {
        return php_sapi_name() == 'cli' || php_sapi_name() == 'phpdbg';
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        return $this->environment;
    }
}