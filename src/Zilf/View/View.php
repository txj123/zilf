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
}