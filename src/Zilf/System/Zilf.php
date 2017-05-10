<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-20
 * Time: 下午2:42
 */

namespace Zilf\System;


use Zilf\Config\Config;
use Zilf\Db\Exception\InvalidConfigException;
use Zilf\Di\Container;

class Zilf
{
    /**
     * @var Application
     */
    public static $app;

    public static $version = '1.0';

    /**
     * @var Container 容器类
     */
    public static $container;

    /**
     * @return string
     * 获取版本信息
     */
    public static function getVersion()
    {
        return self::$version;
    }

    /**
     * Creates a new object using the given configuration.
     *
     * You may view this method as an enhanced version of the `new` operator.
     * The method supports creating an object based on a class name, a configuration array or
     * an anonymous function.
     *
     * Below are some usage examples:
     *
     * ```php
     * // create an object using a class name
     * $object = Yii::createObject('yii\db\Connection');
     *
     * // create an object using a configuration array
     * $object = Yii::createObject([
     *     'class' => 'yii\db\Connection',
     *     'dsn' => 'mysql:host=127.0.0.1;dbname=demo',
     *     'username' => 'root',
     *     'password' => '',
     *     'charset' => 'utf8',
     * ]);
     *
     * // create an object with two constructor parameters
     * $object = \Yii::createObject('MyClass', [$param1, $param2]);
     * ```
     *
     * Using [[\yii\di\Container|dependency injection container]], this method can also identify
     * dependent objects, instantiate them and inject them into the newly created object.
     *
     * @param string|array|callable $type the object type. This can be specified in one of the following forms:
     *
     * - a string: representing the class name of the object to be created
     * - a configuration array: the array must contain a `class` element which is treated as the object class,
     *   and the rest of the name-value pairs will be used to initialize the corresponding object properties
     * - a PHP callable: either an anonymous function or an array representing a class method (`[$class or $object, $method]`).
     *   The callable should return a new instance of the object being created.
     *
     * @param array $params the constructor parameters
     * @return object the created object
     * @throws InvalidConfigException if the configuration is invalid.
     */
    public static function createObject($type, array $params = [])
    {
        if (is_string($type)) {
            static::$container->set($type,$type, $params);
            return static::$container->get($type, $params);

        } elseif (is_array($type) && isset($type['class'])) {
            $class = $type['class'];
            unset($type['class']);

            static::$container->set($class, $class, $type);
            return static::$container->get($class);

        } elseif (is_array($type)) {

            throw new InvalidConfigException('Object configuration must be an array containing a "class" element.');
        } else {
            throw new InvalidConfigException('Unsupported configuration type: ' . gettype($type));
        }
    }

    public static function configure($object, $properties)
    {
        foreach ($properties as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }
}