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
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     * @return Response
     * @throws \Exception
     */
    public function render($view, $parameters = [], Response $response = null)
    {
        $file = $this->getViewFile($view, $parameters);

        //显示页面模板内容
        ob_start();
        ob_implicit_flush(false);
        if($parameters){
            extract($parameters, EXTR_OVERWRITE);
        }
        include($file);
        $buffer = ob_get_clean();

        if (null === $response) {
            $response = new Response();
        }

        return $response->setContent($buffer);
    }

    /**
     * 渲染包含的页面
     */
    public function view($view = '', array $parameters = [])
    {
        $file = $this->getViewFile($view, $parameters);

        //显示页面模板内容
        ob_start();
        //ob_implicit_flush(false);
        extract($parameters, EXTR_OVERWRITE);
        include($file);
        $buffer = ob_get_clean();

        echo $buffer;
    }

    private function getViewFile($view, $parameters = [])
    {
        //优化，如果view有后缀名称，则直接按照后缀寻找视图文件，不会添加默认后缀
        if (stripos($view, '.')) {
            $suffix = '';
        } else {
            $suffix = config_helper('framework.view_suffix');
            $suffix = $suffix ? $suffix : '.php';
        }

        //直接去视图根目录寻找文件
        if (stripos($view, '@') === 0) {
            $view = ltrim($view, '@');
            $path = APP_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR;
        } else {
            $bundle_arr = explode('\\',get_called_class());
            $path = APP_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . strtolower($bundle_arr[1]) . DIRECTORY_SEPARATOR;
        }

        //为空，则自动寻找规则下的视图文件
        if (empty($view)) {
            //$view = strtolower(Zilf::$app->controller) . DIRECTORY_SEPARATOR . Zilf::$app->action;
        }

        $file = $path . $view . $suffix;
        if (!file_exists($file)) {
            throw new \Exception("视图文件" . $file . '不存在');
        }

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