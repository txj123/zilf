<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-6
 * Time: 上午9:58
 */

namespace Zilf\System;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Contracts\Http\Kernel as HttpKernelContract;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Env;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Log\LogServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Zilf\Config\Repository;
use RuntimeException;
use Zilf\Debug\Exceptions\NotFoundHttpException;
use Zilf\Facades\Router;
use Zilf\Routing\Route;

class Application extends Container implements ApplicationContract
{
    /**
     * The Laravel framework version.
     *
     * @var string
     */
    const VERSION = '6.7.0';

    /**
     * The array of terminating callbacks.
     *
     * @var callable[]
     */
    protected $terminatingCallbacks = [];

    /**
     * All of the registered service providers.
     *
     * @var \Illuminate\Support\ServiceProvider[]
     */
    protected $serviceProviders = [];

    /**
     * The names of the loaded service providers.
     *
     * @var array
     */
    protected $loadedProviders = [];

    /**
     * The deferred services and their providers.
     *
     * @var array
     */
    protected $deferredServices = [];

    /**
     * web服务器根目录的路径
     */
    protected $basePath;

    /**
     * Indicates if the application has been bootstrapped before.
     *
     * @var bool
     */
    protected $hasBeenBootstrapped = false;

    /**
     * Indicates if the application has "booted".
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * The array of booting callbacks.
     *
     * @var callable[]
     */
    protected $bootingCallbacks = [];

    /**
     * The array of booted callbacks.
     *
     * @var callable[]
     */
    protected $bootedCallbacks = [];

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
     * The application namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * pathinfo（不含后缀）
     * @var string
     */
    protected $pathInfo;

    protected $bootstrappers = [
        \Zilf\System\Bootstrap\LoadEnvironmentVariables::class,
        \Zilf\System\Bootstrap\LoadConfiguration::class,
        \Zilf\System\Bootstrap\HandleExceptions::class,
        \Zilf\System\Bootstrap\RegisterFacades::class,
        \Zilf\System\Bootstrap\RegisterProviders::class,
        \Zilf\System\Bootstrap\BootProviders::class,
    ];

    public $charset = 'UTF-8';

    public $bundle = 'Index';      //http请求的bundle的名称
    public $controller = 'Index'; //http请求的类的名称
    public $action = 'index';    //http请求的类的方法名称
    public $params = [];        //http请求的参数信息，注：非get,post的参数，是url如：/aa/bb/cc/dd/ee中获取的参数

    public $controller_suffix = 'Controller';
    public $action_suffix = '';
    public $view_suffix = '';

    public $app;
    public $segments = [];
    public $request;

    public $environment;  //开发环境
    public $is_debug = false;  //调试模式是否开启

    public $route;
    protected $is_route = false;
    protected $is_console = false;
    public $database = 'db.default';


    public function __construct($publicPath = null)
    {
        Zilf::$container = new \Zilf\Di\Container();
        Zilf::$app = $this->app = $this;

        if ($publicPath) {
            $this->setBasePath($publicPath);
        }

        $this->registerBaseBindings();

        $this->register(new EventServiceProvider($this));
        $this->register(new LogServiceProvider($this));

        $this->registerCoreContainerAliases();

        $this->singleton(\Illuminate\Contracts\Debug\ExceptionHandler::class, function () {
            return new \Zilf\System\Exceptions\Handler(Zilf::$app);
        });

        $this->instance('request', Request::capture());
        Facade::clearResolvedInstance('request');

        $this->bootstrapWith($this->bootstrappers);
        $this->loadDeferredProviders();

        //获取默认的配置
        $this->initDefaultRoute();

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
            $pathInfo = Zilf::$app->get('request')->getPathInfo();
            if (config('app.sub_domain_deploy')) {
                $host = Zilf::$app->get('request')->getHost();
                $match = explode('.', $host);

                if (count($match) >= 2) {
                    $subDomain = config('app.sub_domain_rules');
                    if ($subDomain) {
                        $domainName = $subDomain[$match[0]] ?? '';
                        if ($domainName) {
                            $this->initDefaultRoute(ucfirst($domainName));
                        }
                    }
                }
            }

            $this->setRoute($pathInfo);
        }
    }

    public function bootstrapWith(array $bootstrappers)
    {
        $this->hasBeenBootstrapped = true;

        foreach ($bootstrappers as $bootstrapper) {
            $this['events']->dispatch('bootstrapping: ' . $bootstrapper, [$this]);

            $this->make($bootstrapper)->bootstrap($this);

            $this['events']->dispatch('bootstrapped: ' . $bootstrapper, [$this]);
        }
    }

    /**
     * Set the environment file to be loaded during bootstrapping.
     *
     * @param string $file
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
        $this->updatePathInfo($pathInfo);

        /**
         * @var Router $router
         */
        $router = Zilf::$app->get('router');
        $routes_config = $this->routesPath() . '/routes.php';   //自定义路由

        if (!$this->is_console && file_exists($routes_config)) {
            include $routes_config; //加载路由的配置文件
        }

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
    }

    /**
     * 获取当前请求URL的pathinfo信息(不含URL后缀)
     * @access public
     * @return string
     */
    public function updatePathInfo($pathinfo)
    {
        if (is_null($this->pathInfo)) {
            $suffix = Zilf::$app->get('config')->get('app.url_html_suffix');

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
    public function initDefaultRoute($bundel = "Index", $controller = 'Index', $action = 'index')
    {
        $this->bundle = $bundel;
        $this->controller = $controller;
        $this->action = $action;
        $this->params = [];
    }

    /**
     * 执行类
     *
     * @throws \Exception
     */
    public function run()
    {
        $request = $this->app->get('request');
        try {
            if ($this->segments instanceof \Closure) {
                echo call_user_func($this->segments);
                die();
            }

            $class = $this->getUnBundleUrl();

            if (!class_exists($class)) {
                $class = $this->getBundleUrl();
                if (!class_exists($class)) {
                    $this->initDefaultRoute();
                    $class = $this->getBundleUrl();
                }
            }

            //将参数追加到GET里面
            if (!empty($this->params)) {
                foreach ($this->params as $key => $row) {
                    if (is_string($key)) {
                        $_GET[$key] = $row;
                    } else {
                        $_GET['zget' . $key] = $row;
                    }
                }
                Zilf::$app->get('request')->query->add($_GET);
            }

            $object = Zilf::$app->make($class, []);
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
            } else {
                throw new \Exception('类: ' . $class . ' 调用的方法：' . $this->action . ' 不存在！');
            }
        } catch (\Exception $e) {
            $this->reportException($e);

            $response = $this->renderException($request, $e);
        } catch (\Throwable $e) {
            $this->reportException($e = new FatalThrowableError($e));

            $response = $this->renderException($request, $e);
        }

        $response->send();
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param \Exception $e
     * @return void
     */
    protected function reportException(\Exception $e)
    {
        $this->app[ExceptionHandler::class]->report($e);
    }

    /**
     * Render the exception to a response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function renderException($request, \Exception $e)
    {
        return $this->app[ExceptionHandler::class]->render($request, $e);
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
     * @param string $databaseName
     * @return $this
     */
    public function getDb($databaseName = '')
    {
        return Zilf::$app->get($databaseName ? $databaseName : $this->database);
    }

    public function setDb($databaseName)
    {
        $this->database = $databaseName;
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

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->instance('app', $this);

        $this->instance(Container::class, $this);

        $this->instance(PackageManifest::class, new PackageManifest(
            new Filesystem, $this->basePath(), $this->getCachedPackagesPath()
        ));
    }

    public function registerCoreContainerAliases()
    {
        foreach ([
                     'app' => [self::class, \Illuminate\Contracts\Container\Container::class, \Illuminate\Contracts\Foundation\Application::class, \Psr\Container\ContainerInterface::class],
                     'blade.compiler' => [\Illuminate\View\Compilers\BladeCompiler::class],
                     'cache' => [\Illuminate\Cache\CacheManager::class, \Illuminate\Contracts\Cache\Factory::class],
                     'cache.store' => [\Illuminate\Cache\Repository::class, \Illuminate\Contracts\Cache\Repository::class, \Psr\SimpleCache\CacheInterface::class],
                     'cache.psr6' => [\Symfony\Component\Cache\Adapter\Psr16Adapter::class, \Symfony\Component\Cache\Adapter\AdapterInterface::class, \Psr\Cache\CacheItemPoolInterface::class],
                     'config' => [\Illuminate\Config\Repository::class, \Illuminate\Contracts\Config\Repository::class],
                     'events' => [\Illuminate\Events\Dispatcher::class, \Illuminate\Contracts\Events\Dispatcher::class],
                     'files' => [\Illuminate\Filesystem\Filesystem::class],
                     'filesystem' => [\Illuminate\Filesystem\FilesystemManager::class, \Illuminate\Contracts\Filesystem\Factory::class],
                     'filesystem.disk' => [\Illuminate\Contracts\Filesystem\Filesystem::class],
                     'filesystem.cloud' => [\Illuminate\Contracts\Filesystem\Cloud::class],
                     'log' => [\Illuminate\Log\LogManager::class, \Psr\Log\LoggerInterface::class],
                     'queue' => [\Illuminate\Queue\QueueManager::class, \Illuminate\Contracts\Queue\Factory::class, \Illuminate\Contracts\Queue\Monitor::class],
                     'queue.connection' => [\Illuminate\Contracts\Queue\Queue::class],
                     'queue.failer' => [\Illuminate\Queue\Failed\FailedJobProviderInterface::class],
                     'redis' => [\Illuminate\Redis\RedisManager::class, \Illuminate\Contracts\Redis\Factory::class],
                     'request' => [\Illuminate\Http\Request::class, \Symfony\Component\HttpFoundation\Request::class],
                     'validator' => [\Illuminate\Validation\Factory::class, \Illuminate\Contracts\Validation\Factory::class],
                     'view' => [\Illuminate\View\Factory::class, \Illuminate\Contracts\View\Factory::class],
                 ] as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.lang', $this->langPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
    }

    public function setBasePath($publicPath)
    {
        $this->basePath = dirname(rtrim($publicPath, '\/'));

        $this->bindPathsInContainer();

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

    public function bootstrapPath($path = '')
    {
        return $this->runtimePath('bootstrap' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }

    public function langPath($path = '')
    {
        return $this->resourcePath() . DIRECTORY_SEPARATOR . 'lang' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function publicPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'public' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    public function storagePath($path = '')
    {
        return $this->runtimePath($path = '');
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
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return '- zilf -' . self::VERSION;
    }

    /**
     * Get or check the current application environment.
     *
     * @param string|array $environments
     * @return string|bool
     */
    public function environment(...$environments)
    {
        if (count($environments) > 0) {
            $patterns = is_array($environments[0]) ? $environments[0] : $environments;

            return Str::is($patterns, $this['env']);
        }

        return $this['env'];
    }

    /**
     * Determine if application is in local environment.
     *
     * @return bool
     */
    public function isLocal()
    {
        return $this['env'] === 'local';
    }

    /**
     * Determine if application is in production environment.
     *
     * @return bool
     */
    public function isProduction()
    {
        return $this['env'] === 'production';
    }

    /**
     * Detect the application's current environment.
     *
     * @param \Closure $callback
     * @return string
     */
    public function detectEnvironment(Closure $callback)
    {
        $args = $_SERVER['argv'] ?? null;

        return $this['env'] = (new EnvironmentDetector)->detect($callback, $args);
    }

    /**
     * Determine if the application is running in the console.
     *
     * @return bool
     */
    public function runningInConsole()
    {
        if (Env::get('APP_RUNNING_IN_CONSOLE') !== null) {
            return Env::get('APP_RUNNING_IN_CONSOLE') === true;
        }

        return php_sapi_name() === 'cli' || php_sapi_name() === 'phpdbg';
    }

    /**
     * Determine if the application is running unit tests.
     *
     * @return bool
     */
    public function runningUnitTests()
    {
        // TODO: Implement runningUnitTests() method.
    }

    /**
     * Register all of the configured providers.
     *
     * @return void
     */
    public function registerConfiguredProviders()
    {
        $providers = Collection::make($this->config['app.providers'])
            ->partition(function ($provider) {
                return Str::startsWith($provider, 'Illuminate\\');
            });

        $providers->splice(1, 0, [$this->make(PackageManifest::class)->providers()]);

        (new ProviderRepository($this, new Filesystem, $this->getCachedServicesPath()))
            ->load($providers->collapse()->toArray());
    }

    /**
     * Get the registered service provider instance if it exists.
     *
     * @param \Illuminate\Support\ServiceProvider|string $provider
     * @return \Illuminate\Support\ServiceProvider|null
     */
    public function getProvider($provider)
    {
        return array_values($this->getProviders($provider))[0] ?? null;
    }

    /**
     * Get the registered service provider instances if any exist.
     *
     * @param \Illuminate\Support\ServiceProvider|string $provider
     * @return array
     */
    public function getProviders($provider)
    {
        $name = is_string($provider) ? $provider : get_class($provider);

        return Arr::where($this->serviceProviders, function ($value) use ($name) {
            return $value instanceof $name;
        });
    }

    /**
     * Resolve a service provider instance from the class name.
     *
     * @param string $provider
     * @return \Illuminate\Support\ServiceProvider
     */
    public function resolveProvider($provider)
    {
        return new $provider($this);
    }

    /**
     * Mark the given provider as registered.
     *
     * @param \Illuminate\Support\ServiceProvider $provider
     * @return void
     */
    protected function markAsRegistered($provider)
    {
        $this->serviceProviders[] = $provider;

        $this->loadedProviders[get_class($provider)] = true;
    }

    /**
     * Register a service provider with the application.
     *
     * @param \Illuminate\Support\ServiceProvider|string $provider
     * @param bool $force
     * @return \Illuminate\Support\ServiceProvider
     */
    public function register($provider, $force = false)
    {

        if (($registered = $this->getProvider($provider)) && !$force) {
            return $registered;
        }

        // If the given "provider" is a string, we will resolve it, passing in the
        // application instance automatically for the developer. This is simply
        // a more convenient way of specifying your service provider classes.
        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        $provider->register();

        // If there are bindings / singletons set as properties on the provider we
        // will spin through them and register them with the application, which
        // serves as a convenience layer while registering a lot of bindings.
        if (property_exists($provider, 'bindings')) {
            foreach ($provider->bindings as $key => $value) {
                $this->bind($key, $value);
            }
        }

        if (property_exists($provider, 'singletons')) {
            foreach ($provider->singletons as $key => $value) {
                $this->singleton($key, $value);
            }
        }

        $this->markAsRegistered($provider);

        // If the application has already booted, we will call this boot method on
        // the provider class so it has an opportunity to do its boot logic and
        // will be ready for any usage by this developer's application logic.
        if ($this->isBooted()) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    /**
     * Load and boot all of the remaining deferred providers.
     *
     * @return void
     */
    public function loadDeferredProviders()
    {
        // We will simply spin through each of the deferred providers and register each
        // one and boot them if the application has booted. This should make each of
        // the remaining services available to this application for immediate use.
        foreach ($this->deferredServices as $service => $provider) {
            $this->loadDeferredProvider($service);
        }

        $this->deferredServices = [];
    }

    /**
     * Load the provider for a deferred service.
     *
     * @param string $service
     * @return void
     */
    public function loadDeferredProvider($service)
    {
        if (!$this->isDeferredService($service)) {
            return;
        }

        $provider = $this->deferredServices[$service];

        // If the service provider has not already been loaded and registered we can
        // register it with the application and remove the service from this list
        // of deferred services, since it will already be loaded on subsequent.
        if (!isset($this->loadedProviders[$provider])) {
            $this->registerDeferredProvider($provider, $service);
        }
    }

    /**
     * Register a deferred provider and service.
     *
     * @param string $provider
     * @param string|null $service
     * @return void
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        // Once the provider that provides the deferred service has been registered we
        // will remove it from our local list of the deferred services with related
        // providers so that this container does not try to resolve it out again.
        if ($service) {
            unset($this->deferredServices[$service]);
        }

        $this->register($instance = new $provider($this));

        if (!$this->isBooted()) {
            $this->booting(function () use ($instance) {
                $this->bootProvider($instance);
            });
        }
    }

    /**
     * Determine if the application has booted.
     *
     * @return bool
     */
    public function isBooted()
    {
        return $this->booted;
    }

    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->isBooted()) {
            return;
        }

        // Once the application has booted we will also fire some "booted" callbacks
        // for any listeners that need to do work after this initial booting gets
        // finished. This is useful when ordering the boot-up processes we run.
        $this->fireAppCallbacks($this->bootingCallbacks);

        array_walk($this->serviceProviders, function ($p) {
            $this->bootProvider($p);
        });

        $this->booted = true;

        $this->fireAppCallbacks($this->bootedCallbacks);
    }

    /**
     * Boot the given service provider.
     *
     * @param \Illuminate\Support\ServiceProvider $provider
     * @return mixed
     */
    protected function bootProvider(ServiceProvider $provider)
    {
        if (method_exists($provider, 'boot')) {
            return $this->call([$provider, 'boot']);
        }
    }

    /**
     * Register a new boot listener.
     *
     * @param callable $callback
     * @return void
     */
    public function booting($callback)
    {
        $this->bootingCallbacks[] = $callback;
    }

    /**
     * Register a new "booted" listener.
     *
     * @param callable $callback
     * @return void
     */
    public function booted($callback)
    {
        $this->bootedCallbacks[] = $callback;

        if ($this->isBooted()) {
            $this->fireAppCallbacks([$callback]);
        }
    }

    /**
     * Call the booting callbacks for the application.
     *
     * @param callable[] $callbacks
     * @return void
     */
    protected function fireAppCallbacks(array $callbacks)
    {
        foreach ($callbacks as $callback) {
            $callback($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function handle(SymfonyRequest $request, $type = 1, $catch = true)
    {
        return $this[HttpKernelContract::class]->handle(Request::createFromBase($request));
    }

    /**
     * Get the fully qualified path to the environment file.
     *
     * @return string
     */
    public function environmentFilePath()
    {
        return $this->environmentPath() . DIRECTORY_SEPARATOR . $this->environmentFile();
    }

    /**
     * Get the path to the cached services.php file.
     *
     * @return string
     */
    public function getCachedServicesPath()
    {
        return $this->normalizeCachePath('APP_SERVICES_CACHE', 'services.php');
    }

    /**
     * Get the path to the cached packages.php file.
     *
     * @return string
     */
    public function getCachedPackagesPath()
    {
        return $this->normalizeCachePath('APP_PACKAGES_CACHE', 'packages.php');
    }

    /**
     * Determine if the application configuration is cached.
     *
     * @return bool
     */
    public function configurationIsCached()
    {
        return file_exists($this->getCachedConfigPath());
    }

    /**
     * Get the path to the configuration cache file.
     *
     * @return string
     */
    public function getCachedConfigPath()
    {
        return $this->normalizeCachePath('APP_CONFIG_CACHE', 'cache/config.php');
    }

    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    public function routesAreCached()
    {
        return $this['files']->exists($this->getCachedRoutesPath());
    }

    /**
     * Normalize a relative or absolute path to a cache file.
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    protected function normalizeCachePath($key, $default)
    {
        if (is_null($env = Env::get($key))) {
            return $this->bootstrapPath($default);
        }

        return Str::startsWith($env, '/')
            ? $env
            : $this->basePath($env);
    }


    /**
     * Throw an HttpException with the given data.
     *
     * @param int $code
     * @param string $message
     * @param array $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function abort($code, $message = '', array $headers = [])
    {
        if ($code == 404) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException($message);
        }

        throw new HttpException($code, $message, null, $headers);
    }

    /**
     * Register a terminating callback with the application.
     *
     * @param callable|string $callback
     * @return self
     */
    public function terminating($callback)
    {
        $this->terminatingCallbacks[] = $callback;

        return $this;
    }

    /**
     * Terminate the application.
     *
     * @return void
     */
    public function terminate()
    {
        foreach ($this->terminatingCallbacks as $terminating) {
            $this->call($terminating);
        }
    }

    /**
     * Get the service providers that have been loaded.
     *
     * @return array
     */
    public function getLoadedProviders()
    {
        return $this->loadedProviders;
    }

    /**
     * Get the application's deferred services.
     *
     * @return array
     */
    public function getDeferredServices()
    {
        return $this->deferredServices;
    }

    /**
     * Set the application's deferred services.
     *
     * @param array $services
     * @return void
     */
    public function setDeferredServices(array $services)
    {
        $this->deferredServices = $services;
    }

    /**
     * Add an array of services to the application's deferred services.
     *
     * @param array $services
     * @return void
     */
    public function addDeferredServices(array $services)
    {
        $this->deferredServices = array_merge($this->deferredServices, $services);
    }

    /**
     * Determine if the given service is a deferred service.
     *
     * @param string $service
     * @return bool
     */
    public function isDeferredService($service)
    {
        return isset($this->deferredServices[$service]);
    }

    /**
     * Configure the real-time facade namespace.
     *
     * @param string $namespace
     * @return void
     */
    public function provideFacades($namespace)
    {
        AliasLoader::setFacadeNamespace($namespace);
    }

    /**
     * Get the path to the routes cache file.
     *
     * @return string
     */
    public function getCachedRoutesPath()
    {
        // TODO: Implement getCachedRoutesPath() method.
    }

    /**
     * Get the current application locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this['config']->get('app.locale');
    }

    /**
     * Get the application namespace.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getNamespace()
    {
        if (!is_null($this->namespace)) {
            return $this->namespace;
        }

        $composer = json_decode(file_get_contents($this->basePath('composer.json')), true);

        foreach ((array)data_get($composer, 'autoload.psr-4') as $namespace => $path) {
            foreach ((array)$path as $pathChoice) {
                if (realpath($this->path()) === realpath($this->basePath($pathChoice))) {
                    return $this->namespace = $namespace;
                }
            }
        }

        throw new RuntimeException('Unable to detect application namespace.');
    }

    /**
     * Determine if the application has been bootstrapped before.
     *
     * @return bool
     */
    public function hasBeenBootstrapped()
    {
        // TODO: Implement hasBeenBootstrapped() method.
    }

    /**
     * Set the current application locale.
     *
     * @param string $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this['config']->set('app.locale', $locale);
    }

    /**
     * Determine if middleware has been disabled for the application.
     *
     * @return bool
     */
    public function shouldSkipMiddleware()
    {
        // TODO: Implement shouldSkipMiddleware() method.
    }
}