<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-2
 * Time: 上午10:34
 */

namespace Zilf\DataCrawler;


class CaijiRules
{
    private $rules;

    function __construct($rules)
    {
        $this->rules = $rules;
    }

    function getRules()
    {
        return $this->rules;
    }
}