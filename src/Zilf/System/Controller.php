<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-11
 * Time: 下午12:59
 */

namespace Zilf\System;


use Zilf\Config\Config;
use Zilf\Db\Connection;
use Zilf\Db\Query;
use Zilf\HttpFoundation\JsonResponse;
use Zilf\HttpFoundation\RedirectResponse;
use Zilf\HttpFoundation\Request;
use Zilf\HttpFoundation\Response;
use Zilf\Log\Writer;
use Zilf\View\Factory;

abstract class Controller
{
    /**
     * @var \Zilf\Di\Container
     */
    public $container;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Config
     */
    public $config;

    public $theme = '';

    /**
     * Controller constructor.
     */
    function __construct()
    {
        header('X-Powered-By:Zilf'); //标识
        $this->container = Zilf::$container;
        $this->config = $this->container->getShare('config');
        $this->request = $this->container->getShare('request');
    }

    /**
     * 获取数据库的对象
     *
     * @param string $default
     * @return Query
     */
    public function getQuery($default = '')
    {
        $object = $this->container->get('query');

        if (!empty($default)) {
            try {
                $properties = $this->config->get('query.' . $default);
                foreach ($properties as $name => $value) {
                    $object->$name = $value;
                }
            } catch (\Exception $e) {
                exit('数据库配置异常,【' . $default . '】配置错误！');
            }
        }

        return $object;
    }

    /**
     * @param $url
     * @param array $params
     * @return string
     */
    public function url($url, $params = [])
    {
        $httpUrl = $this->getRequest()->getSchemeAndHttpHost();
        $paramStr = empty($params) ? '' : '/' . implode('/', $params);
        return $httpUrl . '/' . trim($url, '/') . $paramStr;
    }

    /**
     * Returns a RedirectResponse to the given URL.
     *
     * @param string $url The URL to redirect to
     * @param int $status The status code to use for the Response
     *
     * @return RedirectResponse
     */
    public function redirect($url, $status = 302)
    {
        (new RedirectResponse($url, $status))->send();
    }

    /**
     * Returns a JsonResponse that uses the serializer component if enabled, or json_encode.
     *
     * @param mixed $data The response data
     * @param int $status The status code to use for the Response
     * @param array $headers Array of extra headers to add
     * @param array $context Context to pass to serializer when using serializer component
     *
     * @return String
     */
    public function json($data, $status = 200, $headers = array(), $context = array())
    {
        return (new JsonResponse($data, $status, $headers));
    }

    /**
     * 渲染视图
     *
     * @param string $viewFile
     * @param array $parameters
     * @param Response|null $response
     * @return Response
     * @throws \Exception
     */
    public function render($viewFile, $parameters = [], Response $response = null)
    {
        if (null === $response) {
            $response = new Response();
        }

        return $response->setContent($this->getContent($viewFile, $parameters));
    }

    /**
     * @param $viewFile
     * @param array $parameters
     * @return \Zilf\View\Contracts\View
     */
    public function view($viewFile, $parameters = [])
    {
        return $this->getContent($viewFile, $parameters);
    }

    /**
     * @param $viewFile
     * @param array $parameters
     * @return \Zilf\View\Contracts\View
     */
    private function getContent($viewFile, $parameters = [])
    {
        $viewFile = $this->getViewFile($viewFile, $parameters);

        /**
         * @var $viewFactory Factory
         */
        $viewFactory = Zilf::$container->get('view');
        $parameters['app'] = $this;

        return $viewFactory->make($viewFile, $parameters)->render();
    }

    private function getViewFile($view, $parameters = [])
    {
        //直接去视图根目录寻找文件
        if (stripos($view, '@') === 0) {
            $view = ltrim($view, '@');
            $path = '';
        } else {
            $bundle_arr = explode('\\', get_called_class());
            $path = strtolower($bundle_arr[1]) . DIRECTORY_SEPARATOR;
        }

        $file = $path . $view;

        return $file;
    }

    /**
     * 返回视图的流数据
     *
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     * @return string
     */
    public function stream($view = '', array $parameters = array(), Response $response = null)
    {
        return $this->render($view, $parameters, $response, true);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * 获取url的参数
     *
     * @param int $n
     * @return array|string
     */
    public function getSegment(int $n = 0)
    {
        getSegment($n);
    }

    /**
     * 日志对象
     *
     * @return Writer
     */
    public function getLog()
    {
        return $this->container->getShare('log');
    }
}