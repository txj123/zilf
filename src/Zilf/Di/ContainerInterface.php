<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-11-17
 * Time: 下午3:45
 */

namespace Zilf\Di;


interface ContainerInterface
{

    function register(string $id, $definition, $params = []);

    function get(string $id, array $params = []);

    function getShare(string $id, array $params = []);

    function has(string $id);

    function setAlias($aliasName, $definition = '');

    function getAlias(string $aliasName);
}