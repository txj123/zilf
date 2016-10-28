<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-9-6
 * Time: 下午2:03
 */

namespace Zilf\Di;


/**
 * Class FactoryDefault
 * @package Zilf\Di
 * $di = new FactoryDefault();
 * example:
 * $di->set('finder',new Finder());
 * $finder = $di->get('finder');
 * var_dump($finder);
 * $arr = array('a'=>'eeyy');
 *
 * $di->set('test',function() use ($arr) {
 * print_r($arr);
 * return 'success';
 * });
 *
 * echo $di->get('test');
 */

class Container
{
    /**
     * @var array 存储定义对象的数组
     */
    private $_definitions = [];

    /**
     * @var array 保存参数数组
     */
    private $_parameters = [];


    /**
     * @var array 保存 reflection对象的数组
     */
    private $_reflections = [];


    /**
     * @var array __construnct 方法的参数数据
     */
    private $_dependencies = [];

    /**
     * @var array 对象 需要定义的属性值
     */
    private $_properties = [];

    /**
     * @var array 保存实例对象信息
     */
    private $_objects = [];

    /**
     * @var string 对象执行的方法
     */
    private $_method = [];


    /**
     *  获取共享的对象信息
     * @param $id
     * @return mixed|null|object
     */
    public function getShare($id)
    {
        return $this->get($id, true);
    }

    /**
     * 获取对象信息 默认不共享
     * @param $id
     * @param bool $is_share 是否共享 true 为共享
     * @return mixed|null|object
     * @throws \Exception
     */
    public function get($id, $is_share = true)
    {
        $id = strtolower($id);

        if ($is_share && isset($this->_objects[$id])) {
            // singleton
            return $this->_objects[$id];
        } elseif (!isset($this->_definitions[$id])) {
            throw new \Exception('You have requested a non-existent id: ' . $id);
        }

        $definition = $this->_definitions[$id];
        $params = isset($this->_parameters[$id]) ? $this->_parameters[$id] : '';

        $object = null;
        if (is_callable($definition)) {
            $object = call_user_func($definition, $params);

        } elseif (is_object($definition)) {
            $object = $definition;

        } elseif (is_string($definition)) {
            if (!class_exists($definition)) {
                throw new \Exception('类：' . $definition . '不存在!');
            }

            $object = $this->build($definition, $params);

        } else {
            throw new \Exception('Unexpected object definition type: ' . gettype($definition));
        }

        $this->_objects[$id] = $object;

        if ($method = $this->getMethod($id)) {
            if (!method_exists($object, $method)) {
                throw new \Exception('函数action不存在: ' . $method . ', 类：' . $definition);
            }

            call_user_func_array(array($object, $method), $params);
        }


        return $object;
    }


    public function make($definition, $method = '',$params=[]){
        $this->set($definition,$definition,$params);
        $this->setMethod($definition,$method);
        return $this->get($definition);
    }


    /**
     * Registers a class definition with this container.
     *
     * For example,
     * set('db','\Zilf\Db',array(
     *  'type'=>'pdo_mysql',
     *  'dbname' => ..,
     *  'passwd' => ...
     * ));
     *
     * $definition  可以为回调函数
     * $params  参数
     */
    public function set($id, $definition, array $params = [])
    {
        if (is_string($definition)) {
            if (!class_exists($definition)) {
                throw new \Exception('类：' . $definition . '不存在!');
            }
        }

        $this->setDefinition($id, $definition, $params);
    }

    /**
     * @param $id
     * @return bool
     */
    public function has($id)
    {
        return isset($this->_definitions[$id]);
    }


    /**
     * 保存一个已经定义好的对象
     * @param $class
     * @param $definition
     * @return $this
     */
    public function setInstance($id, $definition)
    {
        $this->_objects[$id] = $definition;

        unset($this->_definitions[$id]);
        return $this;
    }


    /**
     * 定义类
     * @param $id
     * @param $definition
     * @param array $params
     */
    public function setDefinition($id, $definition, array $params = [])
    {
        $id = strtolower($id);

        $this->_definitions[$id] = $definition;
        $this->_parameters[$id] = $params;

        unset($this->_objects[$id]);
        return $this;
    }

    /**
     * 获取多个定义的类的数组
     * @return array
     */
    public function getDefinitions()
    {
        return $this->_definitions;
    }

    /**
     * Returns true if a service definition exists under the given identifier.
     *
     * @param string $id The service identifier
     *
     * @return bool true if the service definition exists, false otherwise
     */
    public function hasDefinition($id)
    {
        return array_key_exists(strtolower($id), $this->_definitions);
    }


    /**
     * Gets a service definition.
     *
     * @param string $id The service identifier
     * @return mixed
     * @throws \Exception
     */
    public function getDefinition($id)
    {
        $id = strtolower($id);

        if (!array_key_exists($id, $this->_definitions)) {
            throw new \Exception('You have requested a non-existent service ' . $id);
        }

        return $this->_definitions[$id];
    }

    /**
     * Removes a service definition.
     *
     * @param string $id The service identifier
     */
    public function removeDefinition($id)
    {
        unset($this->_definitions[strtolower($id)]);
    }

    /**
     * 获取请求的方法
     */
    public function getMethod($id)
    {
        return isset($this->_method[$id]) ? $this->_method[$id] : '';
    }

    /**
     * 设置请求的方法
     * @param $id
     * @param $method
     */
    public function setMethod($id, $method)
    {
        $id = strtolower($id);
        $this->_method[$id] = $method;
    }


    /**
     * @param $class
     * @param $params
     * @param array $config
     * @return object
     * @throws \Exception
     */
    public function build($definition, $params)
    {
        /**
         * @var $reflection (new \Reflection)
         */
        list ($reflection, $dependencies, $properties) = $this->getDependencies($definition);

        $dependencies_arr=[];
        $properties_arr = [];
        foreach ($params as $index => $param) {

            if(array_key_exists($index,$dependencies)){
                $dependencies_arr[] = $param;
            }

            if(array_key_exists($index,$properties)){
                $properties_arr[$index] = $param;
            }

            unset($params[$index]);
            /*
            // php7 的 bug isset没有办法判断
                if (isset($properties[$index])) {
                    echo 'dddd';
                    $properties_arr[$index] = $param;
                }
            */
        }

        //如果传递的参数没有索引值，则剩下的参数，全部以构造器的参数传递
        $dependencies_arr = array_merge($dependencies_arr,$params);

        //判断是否可以初始化
        if (!$reflection->isInstantiable()) {
            throw new \Exception('Can not instantiate ' . $reflection->name);
        }

        $object = null === $reflection->getConstructor() ? $reflection->newInstance() : $reflection->newInstanceArgs($dependencies_arr);

        //设置属性值
        if (!empty($properties_arr)) {
            foreach ($properties_arr as $name => $value) {
                $object->$name = $value;
            }
        }

        return $object;
    }

    /**
     * @param $class
     * @return array
     */
    protected function getDependencies($class)
    {
        if (isset($this->_reflections[$class])) {
            return [$this->_reflections[$class], $this->_dependencies[$class], $this->_properties[$class]];
        }

        $dependencies = [];
        $reflection = new \ReflectionClass($class);

        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $param) {
                $name = $param->getName();
                if ($param->isDefaultValueAvailable()) {
                    $dependencies[$name] = $param->getDefaultValue();
                } else {
                    $dependencies[$name] = '';
                }
            }
        }

        //获取属性信息
        $properties = [];
        $reflectionProperty = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $att_value = $reflection->getDefaultProperties();
        foreach ($reflectionProperty as $property) {
            $name = (string)$property->getName();
            $properties[$name] = $att_value[$name];
        }

        $this->_reflections[$class] = $reflection;
        $this->_dependencies[$class] = $dependencies;
        $this->_properties[$class] = $properties;

        return [$this->_reflections[$class], $this->_dependencies[$class], $this->_properties[$class]];
    }

    /**
     * @param $class
     */
    function invoke($class)
    {

    }

    /**
     * @param string $class
     * @return string
     * 获取类的路径
     */
    public function getClassFilePath($class)
    {
        $reflector = new \ReflectionClass($class);
        return $reflector->getFileName();
    }
}