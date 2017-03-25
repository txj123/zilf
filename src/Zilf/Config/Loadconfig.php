<?php

namespace Zilf\Config;

/**
 * Class Config
 * @package Zilf\Config
 */
class Loadconfig extends Repository
{
    public $configs = array();

    function __construct($config)
    {
        //初始化配置文件
        $config_arr = require($config);
        parent::__construct($config_arr);
    }
}
