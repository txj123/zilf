<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-6
 * Time: 上午9:58
 */

namespace Zilf\System;

use App\Console\Kernel;
use Zilf\Debug\Debug;
use Zilf\Di\Container;
use Zilf\Debug\Exceptions\NotFoundHttpException;
use Zilf\Facades\Router;
use Zilf\HttpFoundation\Response;
use Zilf\Routing\Route;

use Zilf\Support\Request;

class Application
{
    /**
     * web服务器根目录的路径
     */
    protected $basePath;

    /**
     * 数据存储路径
     */
    protected $databasePath;

    /**
     * 缓存路径
     */
    protected $runtimePath;

    /**
     * 环境路径
     */
    protected $environmentPath;

    /**
     * 环境变量文件名
     */
    protected $environmentFile;

    /**
     * pathinfo（不含后缀）
     * @var string
     */
    protected $pathInfo;

    protected $bootstrappers = [
        \Zilf\System\Bootstrap\LoadEnvironmentVariables::class,
        \Zilf\System\Bootstrap\LoadConfiguration::class,
        //        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        //        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Zilf\System\Bootstrap\RegisterProviders::class,
        //        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    public $charset = 'UTF-8';

    public $bundle = 'Index';      //http请求的bundle的名称
    public $controller = 'Index'; //http请求的类的名称
    public $action = 'index';    //http请求的类的方法名称
    public $params = [];        //http请求的参数信息，注：非get,post的参数，是url如：/aa/bb/cc/dd/ee中获取的参数

    public $controller_suffix = 'Controller';
    public $action_suffix = '';
    public $view_suffix = '';


    public $segments = [];
    public $request;

    public $environment;  //开发环境
    public $is_debug = false;  //调试模式是否开启
    /**
     * @var Route
     */
    public $route;
    protected $is_route = false;
    protected $is_console = false;

    public $database = 'db.default';


    public function __construct($publicPath = null)
    {
        Zilf::$container = new Container();
        Zilf::$app = $this;

        if ($publicPath) {
            $this->setBasePath($publicPath);
        }

        $this->registerCoreContainerAliases();

        $this->bootstrapWith($this->bootstrappers);

        //设置异常信息
        if (!\in_array(\PHP_SAPI, array('cli', 'phpdbg'), true)) {
            Debug::enable();
        }

        Zilf::$container->register('request', Request::createFromGlobals());

        //终端访问
        if ($this->runningInConsole()) {
            $this->is_console = true;

            $argv = $_SERVER['argv'];
            $this->setRoute(isset($argv[1]) ? $argv[1] : '');

            $argc = $_SERVER['argc'];
            if ($argc > 2) {
                $this->params = array_slice($argv, 2);
            }
            unset($argc);
            unset($argv);

        } else {
            $pathInfo = Zilf::$container->get('request')->getPathInfo();
            $this->setRoute($pathInfo);
        }
    }

    public function bootstrapWith(array $bootstrappers)
    {
        foreach ($bootstrappers as $bootstrapper) {
            (new $bootstrapper)->bootstrap();
        }
    }

    public function setBasePath($publicPath)
    {
        $this->basePath = dirname(rtrim($publicPath, '\/'));

        return $this;
    }

    public function path($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'app' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function basePath($path = '')
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function langPath($path = '')
    {
        return $this->resourcePath() . DIRECTORY_SEPARATOR . 'lang' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function publicPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'public' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function runtimePath($path = '')
    {
        return $this->runtimePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'runtime' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function configPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function databasePath($path = '')
    {
        return ($this->databasePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'database') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function resourcePath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function routesPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'routes' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function environmentPath()
    {
        return $this->environmentPath ?: $this->basePath;
    }

    /**
     * Set the environment file to be loaded during bootstrapping.
     *
     * @param  string $file
     * @return $this
     */
    public function loadEnvironmentFrom($file)
    {
        $this->environmentFile = $file;

        return $this;
    }

    public function environmentFile()
    {
        return $this->environmentFile ?: '.env';
    }

    /**
     * @param  string $pathInfo
     * @throws \Exception
     */
    public function setRoute($pathInfo = '')
    {
        $this->updatePathInfo($pathInfo);

        //获取默认的配置
        $this->initDefaultRoute();

        /**
         * @var Router $router
         */
        $router = Zilf::$container->getShare('router');
        $routes_config = $this->routesPath() . '/routes.php';   //自定义路由

        if (!$this->is_console && file_exists($routes_config)) {
            //加载路由的配置文件
            include $routes_config;

            $dispatch = $router->check($this->pathInfo, false);
            if ($dispatch['is_route'] === true) {
                $this->is_route = true;

                //路由匹配成功
                if ($dispatch['route'] instanceof \Closure) {
                    $this->segments = $dispatch['route'];
                } else {
                    $this->segments = explode('/', $dispatch['route']);
                }

                $this->option = $dispatch['option'];
                $this->params = $dispatch['param'];
            } else {
                unset($dispatch['is_route']);
                $this->segments = $dispatch;
            }
        } else {
            $this->segments = explode('/', $pathInfo);
        }
    }

    /**
     * 获取当前请求URL的pathinfo信息(不含URL后缀)
     * @access public
     * @return string
     */
    public function updatePathInfo($pathinfo)
    {
        if (is_null($this->pathInfo)) {
            $suffix = Zilf::$container->getShare('config')->get('app.url_html_suffix');

            if (false === $suffix) {
                // 禁止伪静态访问
                $this->pathInfo = $pathinfo;
            } elseif ($suffix) {
                // 去除正常的URL后缀
                $this->pathInfo = preg_replace('/\.(' . ltrim($suffix, '.') . ')$/i', '', $pathinfo);
            } else {
                // 允许任何后缀访问
                $this->pathInfo = preg_replace('/\.' . $this->ext($pathinfo) . '$/i', '', $pathinfo);
            }
        }

        $this->pathInfo = empty($pathinfo) || '/' == $pathinfo ? '' : ltrim($pathinfo, '/');

        return $this->pathInfo;
    }

    /**
     * 当前URL的访问后缀
     * @access public
     * @return string
     */
    public function ext($pathInfo)
    {
        return pathinfo($pathInfo, PATHINFO_EXTENSION);
    }


    /**
     * 初始化默认路由
     */
    public function initDefaultRoute()
    {
        $this->bundle = 'Index';
        $this->controller = 'Index';
        $this->action = 'index';
        $this->params = [];
    }

    /**
     * 执行类
     *
     * @throws \Exception
     */
    public function run()
    {
        if ($this->is_route == true) {
            if ($this->segments instanceof \Closure) {
                echo call_user_func($this->segments);
                die();
            } else {
                $class = $this->getBundleUrl();
            }
        } else {
            $class = $this->getUnBundleUrl();

            if (!class_exists($class)) {

                $this->initDefaultRoute();

                $class = $this->getBundleUrl();
            }
        }

        if (!class_exists($class)) {
            $message = sprintf('No route found for "%s %s"', Zilf::$container['request']->getMethod(), Zilf::$container['request']->getPathInfo());

            if ($referer = Zilf::$container['request']->headers->get('referer')) {
                $message .= sprintf(' (from "%s")', $referer);
            }
            throw new NotFoundHttpException($message);
        }

        unset($this->segments);

        //将参数追加到GET里面
        if (!empty($this->params)) {
            foreach ($this->params as $key => $row) {
                if (is_string($key)) {
                    $_GET[$key] = $row;
                } else {
                    $_GET['zget' . $key] = $row;
                }
            }
            Zilf::$container->getShare('request')->query->add($_GET);
        }

        $object = Zilf::$container->build($class, []);
        if (method_exists($object, $this->action)) {

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

    public function getBundleUrl()
    {
        $segments = $this->segments;

        if ($segments) {
            $this->bundle = ucfirst(strtolower(array_shift($segments)));
        }

        if ($segments) {
            $this->controller = ucfirst(array_shift($segments));
        }

        if ($segments) {
            $this->action = array_shift($segments);
        }

        if ($segments) {
            $this->params = $segments;
        }

        return 'App\\Http\\' . $this->bundle . '\\Controllers\\' . $this->controller . $this->controller_suffix;
    }

    public function getUnBundleUrl()
    {
        $segments = $this->segments;

        if ($segments) {
            $this->controller = ucfirst(array_shift($segments));
        }

        if ($segments) {
            $this->action = array_shift($segments);
        }

        if ($segments) {
            $this->params = $segments;
        }

        return 'App\\Http\\' . $this->bundle . '\\Controllers\\' . $this->controller . $this->controller_suffix;
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
     * 支持db，获取数据库对象
     *
     * @param  string $databaseName
     * @return $this
     */
    public function getDb($databaseName = '')
    {
        return Zilf::$container->getShare($databaseName ? $databaseName : $this->database);
    }

    public function setDb($databaseName)
    {
        $this->database = $databaseName;
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

    public function isDebug()
    {
        return $this->is_debug;
    }

    /**
     * 判断是否是维护模式
     *
     * @return bool
     */
    public function isDownForMaintenance()
    {
        return file_exists($this->runtimePath() . '/down');
    }

    public function registerCoreContainerAliases()
    {
        Zilf::$container->setAlias(
            [
                'config' => \Zilf\Config\Repository::class,
                'files' => \Zilf\Filesystem\Filesystem::class
            ]
        );

        Zilf::$container->register('consoleKernel', function () {
            return new Kernel($this->publicPath());
        });
    }
}