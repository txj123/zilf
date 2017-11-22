<?php

namespace Zilf\Config;

/**
 * Class Config
 *
 * @package Zilf\Config
 */
class LoadConfig extends Repository
{
    public $configs = array();

    /**
     * LoadConfig constructor.
     *
     * @param array $config 配置信息
     */
    function __construct($config)
    {
        //初始化配置文件
        parent::__construct($config);
    }
}
