<?php

namespace Zilf\Redis;

use Zilf\Cache\Exception\InvalidArgumentException;
use Zilf\Helpers\Arr;

class RedisManager
{
    /**
     * The name of the default driver.
     *
     * @var string
     */
    protected $driver;

    /**
     * The Redis server configurations.
     *
     * @var array
     */
    protected $config;

    /**
     * Redis 连接器.
     *
     * @var mixed
     */
    protected $connections;

    /**
     * 创建一个redis管理
     *
     * RedisManager constructor.
     * @param $driver
     * @param array $config
     */
    public function __construct($driver, array $config)
    {
        $this->driver = $driver;
        $this->config = $config;
    }


    /**
     * @param null $name
     * @return Connections\Connection
     */
    public function connection($name = null)
    {
        $name = $name ?: 'default';

        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }

        return $this->connections[$name] = $this->resolve($name);
    }


    /**
     * Resolve the given connection by name.
     *
     * @param  string  $name
     * @return \Zilf\Redis\Connections\Connection
     *
     * @throws \InvalidArgumentException
     */
    protected function resolve($name)
    {
        $options = Arr::get($this->config, 'options', []);

        if (isset($this->config[$name])) {
            return $this->connector()->connect($this->config[$name], $options);
        }

        if (isset($this->config['clusters'][$name])) {
            return $this->resolveCluster($name);
        }

        throw new \InvalidArgumentException(
            "Redis connection [{$name}] not configured."
        );
    }


    /**
     * Resolve the given cluster connection by name.
     *
     * @param  string  $name
     * @return \Zilf\Redis\Connections\Connection
     */
    protected function resolveCluster($name)
    {
        $clusterOptions = Arr::get($this->config, 'clusters.options', []);

        return $this->connector()->connectToCluster(
            $this->config['clusters'][$name], $clusterOptions, Arr::get($this->config, 'options', [])
        );
    }

    /**
     * Get the connector instance for the current driver.
     *
     * @return \Zilf\Redis\Connectors\PhpRedisConnector|\Zilf\Redis\Connectors\PredisConnector
     */
    protected function connector()
    {
        switch ($this->driver) {
            case 'predis':
                return new Connectors\PredisConnector;
            case 'phpredis':
                return new Connectors\PhpRedisConnector;
        }
    }

    /**
     * Pass methods onto the default Redis connection.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->connection()->{$method}(...$parameters);
    }
}