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

    /**
     * Controller constructor.
     */
    function __construct()
    {
        $this->container = Zilf::$container;
        $this->config = $this->container->getShare('config');
        $this->request = $this->container->getShare('request');
    }

    /**
     * @return \Zilf\Di\Container
     * 获取容器
     */
    public function getContainer()
    {
        return Zilf::$container;
    }

    /**
     * 获取数据库的对象
     *
     * @param string $default
     * @return Connection
     */
    public function getDb($default=''){
        $object = $this->container->get('db');

        if(!empty($default)){
            try{
                $properties = $this->config->get('db.'.$default);
                foreach ($properties as $name => $value) {
                    $object->$name = $value;
                }
            }catch (\Exception $e){
                exit('数据库配置异常,【'.$default.'】配置错误！');
            }
        }

        return $object;
    }

    /**
     * 获取数据库的对象
     *
     * @param string $default
     * @return Query
     */
    public function getQuery($default=''){
        $object = $this->container->get('query');

        if(!empty($default)){
            try{
                $properties = $this->config->get('query.'.$default);
                foreach ($properties as $name => $value) {
                    $object->$name = $value;
                }
            }catch (\Exception $e){
                exit('数据库配置异常,【'.$default.'】配置错误！');
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
        if ($this->container->has('serializer')) {
            $json = $this->container->get('serializer')->serialize($data, 'json', array_merge(array(
                'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
            ), $context));

            return (new JsonResponse($json, $status, $headers, true))->send();
        }

        return (new JsonResponse($data, $status, $headers))->send();
    }

    /**
     * 渲染视图
     *
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     * @param bool $return
     * @return string
     * @throws \Exception
     */
    public function render($view = '', array $parameters = array(), Response $response = null, $return = false)
    {
        $suffix = $this->getParameter('framework.view_suffix');
        $suffix = $suffix ? $suffix : '.php';

        $path = Zilf::$container->getClassFilePath(get_called_class());

        if (empty($view)) {
            $view = Zilf::$app->controller . '/' . Zilf::$app->action . $suffix;
        } else {
            $view = $view . $suffix;
        }

        $file = dirname(dirname($path)) . '/Views/' . $view;
        if (!file_exists($file)) {
            throw new \Exception("视图文件" . $file . '没有找到');
        }

        //显示页面模板内容
        ob_start();
        ob_implicit_flush(false);
        extract($parameters, EXTR_OVERWRITE);
        include($file);
        $buffer = ob_get_clean();

        if ($return) {
            return $buffer;
        } else {
            if (null === $response) {
                $response = new Response();
            }

            $response->setContent($buffer);
            $response->send();
        }
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
     * @param $name
     * @return Config
     */
    public function getParameter($name)
    {
        $config = $this->container->getShare('config');
        return $config->get($name);
    }

    /**
     * 获取url的参数
     */
    public function getSegment($n=''){
        $segments = Zilf::$app->segments;
        if($n){
            return isset($segments[$n]) ? $segments[$n] : '';
        }else{
            return $segments;
        }
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