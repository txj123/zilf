<?php

namespace Zilf\Facades;

/**
 * @method static bool set($key, $value, $timeout = 0)
 * @method static bool setex($key, $ttl, $value)
 * @method static bool setnx($key, $value)
 * @method static int del($key1, $key2 = null, $key3 = null)
 * @method static int delete($key1, $key2 = null, $key3 = null)
 * @method static void watch($key)
 * @method static bool mset(array $array)
 * @method static int bitCount($key)
 * @method static string get($key)
 * @method static array  mget(array $array)
 * @method static bool  expire($key, $ttl)
 * @method static bool  pExpire($key, $ttl)
 * @method static bool  setTimeout($key, $ttl)
 * @method static array  keys($pattern)
 * @method static int  dbSize()
 * @method static string  getRange($key, $start, $end)
 * @method static int  strlen($key)
 * @method static bool  persist($key)
 * @method static bool  exists($key)
 * @method static int ttl($key)
 * @method static bool select($dbindex)
 * @method static int  flushDB()
 * @method static int  flushAll()
 * @method static bool  save()
 * @method static bool  bgsave()
 * @method static int  lastSave()
 * @method static int  wait($numSlaves, $timeout)
 * @method static int  type($key)
 * @method static int append($key, $value)
 *
 * @see \Zilf\Redis\RedisManager
 */
class Redis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }
}
