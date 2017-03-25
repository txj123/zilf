<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zilf\Cache\Tests\Simple;

use Zilf\Cache\Simple\ArrayCache;

/**
 * @group time-sensitive
 */
class ArrayCacheTest extends CacheTestCase
{
    public function createSimpleCache($defaultLifetime = 0)
    {
        return new ArrayCache($defaultLifetime);
    }
}
