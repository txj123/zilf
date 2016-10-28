<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zilf\Cache\Tests;

use Zilf\Cache\CacheItem;

class CacheItemTest extends \PHPUnit_Framework_TestCase
{
    public function testValidKey()
    {
        $this->assertNull(CacheItem::validateKey('foo'));
    }

    /**
     * @dataProvider provideInvalidKey
     * @expectedException Zilf\Cache\Exception\InvalidArgumentException
     * @expectedExceptionMessage Cache key
     */
    public function testInvalidKey($key)
    {
        CacheItem::validateKey($key);
    }

    public function provideInvalidKey()
    {
        return array(
            array(''),
            array('{'),
            array('}'),
            array('('),
            array(')'),
            array('/'),
            array('\\'),
            array('@'),
            array(':'),
            array(true),
            array(null),
            array(1),
            array(1.1),
            array(array()),
            array(new \Exception('foo')),
        );
    }
}
