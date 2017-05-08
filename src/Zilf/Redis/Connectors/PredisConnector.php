<?php

namespace Zilf\Redis\Connectors;

use Predis\Client;
use Zilf\Helpers\Arr;
use Zilf\Redis\Connections\PredisConnection;
use Zilf\Redis\Connections\PredisClusterConnection;

class PredisConnector
{
    /**
     * Create a new clustered Predis connection.
     *
     * @param  array  $config
     * @param  array  $options
     * @return \Zilf\Redis\Connections\PredisConnection
     */
    public function connect(array $config, array $options)
    {
        return new PredisConnection(new Client($config, array_merge(
            ['timeout' => 10.0], $options, Arr::pull($config, 'options', [])
        )));
    }

    /**
     * Create a new clustered Predis connection.
     *
     * @param  array  $config
     * @param  array  $clusterOptions
     * @param  array  $options
     * @return \Zilf\Redis\Connections\PredisClusterConnection
     */
    public function connectToCluster(array $config, array $clusterOptions, array $options)
    {
        $clusterSpecificOptions = Arr::pull($config, 'options', []);

        return new PredisClusterConnection(new Client(array_values($config), array_merge(
            $options, $clusterOptions, $clusterSpecificOptions
        )));
    }
}
