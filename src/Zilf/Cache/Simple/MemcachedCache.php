<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zilf\Cache\Simple;

use Zilf\Cache\Traits\MemcachedTrait;

class MemcachedCache extends AbstractCache
{
    use MemcachedTrait;

    protected $maxIdLength = 250;

    public function __construct(\Memcached $client, $namespace = '', $defaultLifetime = 0)
    {
        $this->init($client, $namespace, $defaultLifetime);
    }
}
