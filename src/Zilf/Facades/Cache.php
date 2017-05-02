<?php
/**
 * Created by PhpStorm.
 * User: lilei
 * Date: 17-4-27
 * Time: 下午2:50
 */

namespace Zilf\Facades;

/**
 * #CacheManager
 * @method static \Zilf\Cache\Repository store($name = null)
 * @method static mixed driver($driver = null)
 * @method static \Zilf\Cache\Repository repository(Store $store)
 * @method static string getDefaultDriver()
 * @method static void setDefaultDriver($name)
 * @method static $this extend($driver, Closure $callback)
 * @method static mixed __call($method, $parameters)
 *
 * #Store
 * @method static mixed get($key, $default = null)
 * @method static array  many(array $keys)
 * @method static void  put($key, $value, $minutes)
 * @method static void  putMany(array $values, $minutes)
 * @method static int|bool  increment($key, $value = 1)
 * @method static int|bool  decrement($key, $value = 1)
 * @method static void  forever($key, $value)
 * @method static bool  forget($key)
 * @method static bool   flush()
 * @method static string getPrefix()
 *
 * #Repository
 * @method static bool has($key)
 * @method static mixed pull($key, $default = null)
 * @method static bool add($key, $value, $minutes)
 * @method static mixed remember($key, $minutes, Closure $callback)
 * @method static mixed sear($key, Closure $callback)
 * @method static mixed rememberForever($key, Closure $callback)
 * @method static \Zilf\Cache\TaggedCache tags($names)
 * @method static float|int getDefaultCacheTime()
 * @method static $this setDefaultCacheTime($minutes)
 * @method static \Zilf\Cache\Store getStore()
 * @method static bool offsetExists($key)
 * @method static mixed offsetGet($key)
 * @method static void offsetSet($key, $value)
 * @method static void offsetUnset($key)
 *
 * #FileStore
 * @method static \Zilf\Filesystem\Filesystem getFilesystem()
 * @method static string getDirectory()
 *
 * #RedisStore
 * @method static \Zilf\Redis\RedisManager getRedis()
 * @method static void setPrefix($prefix)
 * @method static \Predis\ClientInterface connection()
 * @method static void setConnection($connection)
 *
 * Class Cache
 * @package Zilf\Facades
 */
class Cache extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cache';
    }
}