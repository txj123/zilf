<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 16-11-17
 * Time: 下午3:36
 */

namespace Zilf\Di;

use ArrayAccess;

class Container implements ArrayAccess, ContainerInterface
{

    /**
     * @var array 存储定义对象的数组
     */
    private $_definitions = [];

    /**
     * @var array 存储类的属性值
     */
    private $_defaultProperties = [];

    /**
     * @var array 存储类的__construnct()的参数信息
     */
    private $_dependencies = [];

    /**
     * @var array 保存 reflection对象的数组
     */
    private $_reflections = [];

    /**
     * @var array 存储别名的数组
     */
    private $_alias = [];

    private $_objects = [];
    private $_id;

    const TYPE_DEFINITION_OBJ = 1;  //参数类型是对象
    const TYPE_DEFINITION_CALLBACK = 2; //参数类型是回调函数
    const TYPE_DEFINITION_STRING = 3;  //参数类型是字符串
    const TYPE_DEFINITION_INSTANCE = 4;  //单例模式的参数类型

    /**
     * 获取类的对象
     *
     * @param $id
     * @param array $params
     * @return $this
     * @throws \Exception
     */
    public function get(string $id, array $params = [])
    {
        if (empty($id)) {
            throw new \Exception('参数 id 不能为空');
        }
        $id = strtolower($id);
        $this->_id = $id;

        //别名
        if ($this->hasAlias($this->_id)) {
            $this->_definitions[$this->_id] = $this->_alias[$this->_id];
        }

        if ($this->has($this->_id)) {
            $definition = $this->_definitions[$this->_id];
        } else {
            throw new \Exception('获取的' . $this->_id . '不存在');
        }

        $object = null;
        if (!empty($params)) {
            $definition['params'] = (array)$params;
        }
        $class = $definition['class'];
        $params = empty($definition['params']) ? [] : $definition['params'];
        $type = $definition['type'];

        if ($type == self::TYPE_DEFINITION_CALLBACK) {
            $object = call_user_func($class, $params);

        } elseif ($type == self::TYPE_DEFINITION_OBJ) {
            $object = $class;

        } elseif ($type == self::TYPE_DEFINITION_STRING) {
            if (!class_exists($class)) {
                throw new \Exception('类：' . $class . '不存在!');
            }

            $object = $this->build($class, $params);

        } else {
            throw new \Exception('Unexpected object definition type: ' . gettype($class));
        }

        //清除变量 释放内存
        unset($definition);
        unset($class);
        unset($params);
        unset($type);
        unset($id);

        return $object;
    }

    /**
     * 获取共享的对象，类仅仅实例化一次
     *
     * @param $id
     * @param array $params
     * @return mixed|null
     * @throws \Exception
     */
    public function getShare(string $id, array $params = [])
    {
        $id = strtolower($id);
        if (isset($this->_objects[$id]) && !empty($this->_objects[$id])) {
            return $this->_objects[$id];
        } elseif (!isset($this->_definitions[$id])) {
            throw new \Exception('You have requested a non-existent id: ' . $id);
        } else {
            return $this->get($id, $params);
        }
    }


    /**
     * 注册定义的类
     * 指定该类对应的__construnct()参数，已经函数方法的参数
     *
     * 使用说明：
     * //curl不存在
     * register('curl','Zilf\Curl\Curl',parmas);//params 参数为构造函数的参数
     * register('curl',['Zilf\Curl\Curl','方法']',[ '__construct'=[] , 'other1'='11','other2'='22' ]);//params 参数为构造函数的参数
     * register('curl','Zilf\Curl\Curl@方法',[ '__construct'=[] , 'other1'='11','other2'='22' ]);//params 参数为构造函数的参数
     *
     * //curl已经存在
     * register('curl',params)  //params 参数为构造函数的参数
     *
     * //回调函数
     * register('curl',new \Zilf\Curl\Curl());
     *
     * //回调函数
     * register('curl',function(){
     *      return new \Zilf\Curl\Curl();
     * });
     *
     * @param string $id 为别名,或者类的对象字符串
     * @param string $definition 支持类的对象,类的对象字符串，回调函数
     * @param array $params 传递的参数，数组或者字符串，允许为空
     * @return $this
     * @throws \Exception
     */
    public function register(string $id, $definition, $params = [])
    {
        $this->_id = strtolower($id);

        //清除已经存在的对象信息
        unset($this->_objects[$id]);

        if (isset($this->_alias[$this->_id])) {  //别名存在
            //如果$definition是数组，则作为参数传递
            if (!empty($definition) && is_array($definition)) {
                $this->_alias[$this->_id]['params'] = $definition;
            }

            //参数重新赋值
            if (!empty($params)) {
                $this->_alias[$this->_id]['params'] = $params;
            }

            $class = array(
                'class' => $this->_alias[$this->_id]['class'],
                'params' => $this->_alias[$this->_id]['params'],
                'type' => $this->_alias[$this->_id]['type'],
            );
        } elseif (is_callable($definition)) { //
            $class = array(
                'class' => $definition,
                'params' => [],
                'type' => self::TYPE_DEFINITION_CALLBACK,
            );
        } elseif (is_object($definition)) {  //是对象
            $class = array(
                'class' => $definition,
                'params' => [],
                'type' => self::TYPE_DEFINITION_OBJ,
            );
        } elseif (is_array($definition)) {
            if (count($definition) != 2) {
                throw new \Exception('注册的参数错误，只能输入controller和action方法');
            }

            $class = array(
                'class' => $definition[0] ?? '',
                'params' => $params,
                'method' => $definition[1] ?? '',
                'type' => self::TYPE_DEFINITION_STRING,
            );
            $this->setAlias($this->_id, $definition);
        } else {
            $class = array(
                'class' => $definition,
                'params' => $params,
                'type' => self::TYPE_DEFINITION_STRING,
            );
        }

        //定义类
        $this->_alias[$id] = $class;
        $this->_definitions[$this->_id] = $class;
        unset($id);
        unset($definition);
        unset($class);

        return $this;
    }

    /**
     * 函数register的别名
     * @param $id
     * @param $definition
     * @param array $params
     * @return $this
     */
    public function set(string $id, $definition, $params = [])
    {
        return $this->register($id, $definition, $params);
    }


    /**
     * 判断注册的对象或者回调函数是否存在
     *
     * @param $id
     * @return bool
     */
    public function has(string $id)
    {
        return isset($this->_definitions[$id]);
    }


    /**
     * 获取定义的所有的数据信息数组
     * @return array
     */
    public function getDefinitions()
    {
        return $this->_definitions;
    }


    /**
     * 设置类的别名
     *
     * @param string|array $aliasName
     * @param string $definition //回调函数 字符串 对象
     * @return $this
     */
    public function setAlias($aliasName, $definition = '')
    {
        if (is_array($aliasName) && !empty($aliasName)) {
            foreach ($aliasName as $id => $item) {
                $this->_alias[$id] = array(
                    'class' => $item,
                    'params' => '',
                    'type' => self::TYPE_DEFINITION_STRING,
                );
            }
        } else {
            $aliasName = strtolower($aliasName);
            $this->_alias[$aliasName] = array(
                'class' => $definition,
                'params' => '',
                'type' => self::TYPE_DEFINITION_STRING,
            );
        }

        return $this;
    }


    /**
     * 获取别名的value值
     *
     * @param $aliasName
     * @return mixed|string
     */
    public function getAlias(string $aliasName)
    {
        $aliasName = strtolower($aliasName);
        return isset($this->_alias[$aliasName]) ? $this->_alias[$aliasName] : '';
    }


    /**
     * 获取所有的别名
     */
    public function getAllAlias()
    {
        return $this->_alias;
    }


    /**
     * 判断别名是否存在
     *
     * @param string $aliasName 别名
     * @return bool
     */
    public function hasAlias(string $aliasName)
    {
        return isset($this->_alias[$aliasName]);
    }


    /**
     * 重新命名别名的名称
     *
     * @param string $aliasName 原来的别名
     * @param string $newAliasName 新的别名
     * @return $this
     * @throws \Exception
     */
    public function renameAlias(string $aliasName, string $newAliasName)
    {
        $aliasName = strtolower($aliasName);
        $newAliasName = strtolower($newAliasName);
        if ($this->hasAlias($aliasName)) {
            $this->_alias[$newAliasName] = $this->_alias[$aliasName];
            unset($this->_alias[$aliasName]);
        } else {
            throw new \Exception('该别名' . $aliasName . '没有不存在');
        }

        return $this;
    }


    /**
     * 获取类文件的绝对路径
     *
     * @param string $class
     * @return string
     */
    public function getClassFilePath($class)
    {
        $reflector = new \ReflectionClass($class);
        return $reflector->getFileName();
    }


    /**
     * 根绝类的字符串，返回类的对象
     *
     * @param string $definition 字符串
     * @param array $params 传递的参数
     * @return mixed
     * @throws \Exception
     */
    public function build($definition, array $params = [])
    {
        /**
         * @var $reflection (new \Reflection)
         */
        list ($reflection, $dependencies, $props) = $this->getDependencies($definition);
        $this->_reflections[$this->_id] = $reflection;

        //根绝$dependencies的参数位置，赋值参数
        //注意 参数的匹配以key相同为优先，其他怎按照索引排序
        if (!empty($params)) {
            $index = 0;
            foreach ($dependencies as $key => $value) {
                if (isset($params[$key])) {
                    $dependencies[$key] = $params[$key];
                } elseif (!empty($dependencies[$key])) {
                } elseif (isset($params[$index])) {
                    $dependencies[$key] = $params[$index];
                    $index++;
                }
            }
        }

        //判断是否可以初始化
        if (!$reflection->isInstantiable()) {
            throw new \Exception('Can not instantiate ' . $reflection->name);
        }

        $object = null === empty($dependencies) ? $reflection->newInstance() : $reflection->newInstanceArgs($dependencies);

        //初始化对象的属性
        if (!empty($props)) {
            foreach ($props as $prop) {
                $key = $prop->getName();
                if (isset($params[$key]) && !empty($params[$key])) {
                    $object->$key = $params[$key];
                }
            }
        }

        return $object;
    }


    /**
     * 获取类的构造函数的参数，以及reflections对象
     *
     * @param $class
     * @return array
     */
    private function getDependencies($class)
    {
        if (isset($this->_reflections[$class])) {
            return [$this->_reflections[$class], $this->_dependencies[$class], $this->_defaultProperties[$class]];
        }

        $dependencies = [];
        $reflection = new \ReflectionClass($class);

        //获取类的公共public属性
        $props = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);

        //获取构造器的参数
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

        $this->_reflections[$class] = $reflection;
        $this->_dependencies[$class] = $dependencies;
        $this->_defaultProperties[$class] = $props;

        unset($reflection);
        unset($defaultProperties);
        unset($dependencies);
        unset($constructor);

        return [$this->_reflections[$class], $this->_dependencies[$class], $this->_defaultProperties[$class]];
    }


    /**
     * 清空容器内所有绑定的数据
     */
    public function flush()
    {
        $this->_alias = [];
        $this->_definitions = [];
        $this->_reflections = [];
        $this->_objects = [];
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function offsetExists($id)
    {
        return $this->has($id);
    }

    /**
     * Whether a offset exists
     *
     * @param string $id
     * @return Container
     */
    public function offsetGet($id)
    {
        return $this->get($id);
    }

    /**
     * Offset to set
     *
     * @param string $id
     * @param mixed $value
     */
    public function offsetSet($id, $value)
    {
        if (is_array($value)) {
            $param1 = isset($value[0]) ? $value[0] : '';
            $param2 = isset($value[1]) ? $value[1] : '';
            $this->set($id, $param1, $param2);
        } else {
            $this->set($id, $value);
        }
    }

    /**
     * Offset to unset
     *
     * @param string $id
     */
    public function offsetUnset($id)
    {
        unset($this->_definitions[$id]);
    }
}