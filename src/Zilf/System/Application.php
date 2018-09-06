<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-6
 * Time: 上午9:58
 */

namespace Zilf\System;

use Zilf\Debug\Debug;
use Zilf\Di\Container;
use Zilf\Debug\Exceptions\NotFoundHttpException;
use Zilf\HttpFoundation\Response;
use Zilf\Routing\Route;
use Zilf\Support\Request;

class Application
{
    /**
     * Zilf 框架的版本号
     */
    const VERSION = '5.6.24';

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
        Debug::enable();

        Zilf::$container->register('request', Request::createFromGlobals());

        //终端访问
        if ($this->runningInConsole()) {

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

    public function langPath()
    {
        return $this->resourcePath() . DIRECTORY_SEPARATOR . 'lang';
    }

    public function publicPath()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'public';
    }

    public function runtimePath()
    {
        return $this->runtimePath ?: $this->basePath . DIRECTORY_SEPARATOR . 'runtime';
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
     * @param string $pathInfo
     * @throws \Exception
     */
    public function setRoute($pathInfo = '')
    {
        //自定义路由
        $route = Zilf::$container->get('router');
        $routes_config = $this->routesPath() . '/routes.php';

        if (file_exists($routes_config)) {
            //加载路由的配置文件
            include $routes_config;

            $class_exec = $route->dispatch($pathInfo);
            if ($class_exec) {

                list($pcre, $pattern, $cb, $options) = $class_exec;
                $segments = explode('\\', $cb[0]);

                $this->bundle = $segments[2];
                $this->controller = rtrim($segments[4], $this->controller_suffix);
                $this->action = $cb[1] . $this->action_suffix;
                $this->params = isset($options['vars']) ? $options['vars'] : [];

            } else {
                $pathInfo = trim($pathInfo, '/');

                //设置路由
                if ($pathInfo) {

                    $this->segments = explode('/', $pathInfo);

                } else {
                    //获取默认的配置
                    $framework = Zilf::$container->getShare('config')->get('app.framework');
                    if (!empty($framework)) {
                        foreach ($framework as $key => $value) {
                            if ($value) {
                                $this->$key = $value;
                            }
                        }
                    }
                }

            }
        }
    }

    /**
     * 执行类
     *
     * @throws \Exception
     */
    function run()
    {
        $class = $this->getUnBundleUrl();
        if (!class_exists($class)) {

            $class = $this->getBundleUrl();
            if (!class_exists($class)) {
                $message = sprintf('No route found for "%s %s"', Zilf::$container['request']->getMethod(), Zilf::$container['request']->getPathInfo());

                if ($referer = Zilf::$container['request']->headers->get('referer')) {
                    $message .= sprintf(' (from "%s")', $referer);
                }
                throw new NotFoundHttpException($message);
            }
        }

        unset($this->segments);

        $object = Zilf::$container->build($class, []);
        if (method_exists($object, $this->action)) {

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

    public function registerCoreContainerAliases()
    {
        Zilf::$container->setAlias([
            'app' => \Zilf\System\Application::class,
            'blade.compiler' => \Zilf\View\Compilers\BladeCompiler::class,
            'cache' => \Zilf\Cache\CacheManager::class,
            'cache.store' => \Zilf\Cache\Repository::class,
            'config' => \Zilf\Config\Repository::class,
            'encrypter' => \Zilf\Security\Encrypt\Encrypter::class,
            'db' => \Zilf\Db\Connection::class,
            'files' => \Zilf\Filesystem\Filesystem::class,
            'log' => \Zilf\Log\LogManager::class,
            'redis' => \Zilf\Redis\RedisManager::class,
            'request' => \Zilf\Support\Request::class,
            'router' => \Zilf\Routing\Route::class,
            'validator' => \Zilf\Validation\Factory::class,
            'view' => \Zilf\View\Factory::class,
            'consoleKernel' => \App\Console\Kernel::class
        ]);
    }
}