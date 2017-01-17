<?php
namespace Zilf\View;
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-11-21
 * Time: 上午10:10
 */
class View
{
    public $defaultExtension = 'php';

    function __construct()
    {
        //优化，如果view有后缀名称，则直接按照后缀寻找视图文件，不会添加默认后缀
        $suffix = $this->getParameter('framework.view_suffix');
        $this->defaultExtension = $suffix ?? '.php';
    }

    public function getViewPath(){
        $path = Zilf::$container->getClassFilePath(get_called_class());

    }

    protected function findViewFile($view, $context = null)
    {
        if (strncmp($view, '@', 1) === 0) {
            // e.g. "@http/views/main"  将会从bundle中去寻找当前的视图文件
//            $file = Yii::getAlias($view);
        } elseif (strncmp($view, '//', 2) === 0) {
            // e.g. "//layouts/main"
            $file = Yii::$app->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
        } elseif (strncmp($view, '/', 1) === 0) {
            // e.g. "/site/index"
            if (Yii::$app->controller !== null) {
                $file = Yii::$app->controller->module->getViewPath() . DIRECTORY_SEPARATOR . ltrim($view, '/');
            } else {
                throw new InvalidCallException("Unable to locate view file for view '$view': no active controller.");
            }
        } elseif ($context instanceof ViewContextInterface) {
            $file = $context->getViewPath() . DIRECTORY_SEPARATOR . $view;
        } elseif (($currentViewFile = $this->getViewFile()) !== false) {
            $file = dirname($currentViewFile) . DIRECTORY_SEPARATOR . $view;
        } else {
            throw new InvalidCallException("Unable to resolve view file for view '$view': no active view context.");
        }

        if (pathinfo($file, PATHINFO_EXTENSION) !== '') {
            return $file;
        }
        $path = $file . '.' . $this->defaultExtension;
        if ($this->defaultExtension !== 'php' && !is_file($path)) {
            $path = $file . '.php';
        }

        return $path;
    }
}