<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 18-12-5
 * Time: 下午12:49
 */

namespace Zilf\Facades;

/**
 * @method \Zilf\Routing\Domain domain(mixed $name, mixed $rule = '', array $option = [], array $pattern = []) static 注册域名路由
 * @method \Zilf\Routing\Router pattern(mixed $name, string $rule = '') static 注册变量规则
 * @method \Zilf\Routing\Router option(mixed $name, mixed $value = '') static 注册路由参数
 * @method \Zilf\Routing\Router bind(string $bind) static 设置路由绑定
 * @method mixed getBind(string $bind) static 读取路由绑定
 * @method \Zilf\Routing\Router name(string $name) static 设置当前路由标识
 * @method mixed getName(string $name) static 读取路由标识
 * @method void setName(string $name) static 批量导入路由标识
 * @method void import(array $rules, string $type = '*') static 导入配置文件的路由规则
 * @method \Zilf\Routing\RuleItem rule(string $rule, mixed $route, string $method = '*', array $option = [], array $pattern = []) static 注册路由规则
 * @method void rules(array $rules, string $method = '*', array $option = [], array $pattern = []) static 批量注册路由规则
 * @method \Zilf\Routing\RuleGroup group(string|array $name, mixed $route, string $method = '*', array $option = [], array $pattern = []) static 注册路由分组
 * @method \Zilf\Routing\RuleItem any(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \Zilf\Routing\RuleItem get(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \Zilf\Routing\RuleItem post(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \Zilf\Routing\RuleItem put(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \Zilf\Routing\RuleItem delete(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \Zilf\Routing\RuleItem patch(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册路由
 * @method \Zilf\Routing\Resource resource(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册资源路由
 * @method \Zilf\Routing\Router controller(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册控制器路由
 * @method \Zilf\Routing\Router alias(string $rule, mixed $route, array $option = [], array $pattern = []) static 注册别名路由
 * @method \Zilf\Routing\Router setMethodPrefix(mixed $method, string $prefix = '') static 设置不同请求类型下面的方法前缀
 * @method \Zilf\Routing\Router rest(string $name, array $resource = []) static rest方法定义和修改
 * @method \Zilf\Routing\RuleItem miss(string $route, string $method = '*', array $option = []) static 注册未匹配路由规则后的处理
 * @method \Zilf\Routing\RuleItem auto(string $route) static 注册一个自动解析的URL路由
 * @method \Zilf\Routing\Router check(string $url, string $depr = '/', bool $must = false, bool $completeMatch = false) static 检测URL路由
 *
 * Class Router
 * @package Zilf\Facades
 */

class Router extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'router';
    }
}