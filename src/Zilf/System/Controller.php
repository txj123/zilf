<?php

namespace Zilf\System;

use Zilf\HttpFoundation\JsonResponse;
use Zilf\HttpFoundation\RedirectResponse;
use Zilf\HttpFoundation\Request;
use Zilf\HttpFoundation\Response;

use Zilf\System\Bus\DispatchesJobs;
use Zilf\View\Factory;

abstract class Controller
{
    use DispatchesJobs;

    public $theme = '';

    /**
     * Controller constructor.
     */
    function __construct()
    {
        header('X-Powered-By:Zilf'); //标识
    }

    /**
     * Returns a RedirectResponse to the given URL.
     *
     * @param string $url    The URL to redirect to
     * @param int    $status The status code to use for the Response
     *
     * @return RedirectResponse
     */
    public function redirect($url, $status = 302)
    {
        return (new RedirectResponse($url, $status))->send();
    }

    /**
     * Returns a JsonResponse that uses the serializer component if enabled, or json_encode.
     *
     * @param mixed $data    The response data
     * @param int   $status  The status code to use for the Response
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
     * @param  string        $viewFile
     * @param  array         $parameters
     * @param  Response|null $response
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
     * @return string
     * @throws \Exception
     */
    public function view($viewFile, $parameters = [])
    {
        return $this->getContent($viewFile, $parameters);
    }

    /**
     * @param $viewFile
     * @param array $parameters
     * @return string
     * @throws \Exception
     */
    private function getContent($viewFile, $parameters = [])
    {
        $viewFile = $this->getViewFile($viewFile, $parameters);

        /**
         * @var $viewFactory Factory
         */
        $viewFactory = Zilf::$container->get('view');
        if(!isset($parameters['app'])) {
            $parameters['app'] = $this;
        }

        return $viewFactory->make($viewFile, $parameters)->render();
    }

    private function getViewFile($view, $parameters = [])
    {
        //直接去视图根目录寻找文件
        if (stripos($view, '@') === 0) {
            $view = ltrim($view, '@');
            $path = '';
        } else {
            $path = $this->theme ? $this->theme . DIRECTORY_SEPARATOR : '';
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
     * @return Response
     * @throws \Exception
     */
    public function stream($view = '', array $parameters = array(), Response $response = null)
    {
        return $this->render($view, $parameters, $response);
    }
}