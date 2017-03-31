<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zilf\Cache\Tests\Adapter;

use Zilf\Cache\Adapter\FilesystemAdapter;
use Zilf\Cache\Adapter\PhpArrayAdapter;

/**
 * @group time-sensitive
 */
class PhpArrayAdapterWithFallbackTest extends AdapterTestCase
{
    protected $skippedTests = array(
        'testGetItemInvalidKeys' => 'PhpArrayAdapter does not throw exceptions on invalid key.',
        'testGetItemsInvalidKeys' => 'PhpArrayAdapter does not throw exceptions on invalid key.',
        'testHasItemInvalidKeys' => 'PhpArrayAdapter does not throw exceptions on invalid key.',
        'testDeleteItemInvalidKeys' => 'PhpArrayAdapter does not throw exceptions on invalid key.',
        'testDeleteItemsInvalidKeys' => 'PhpArrayAdapter does not throw exceptions on invalid key.',
    );

    protected static $file;

    public static function setupBeforeClass()
    {
        self::$file = sys_get_temp_dir().'/symfony-cache/php-array-adapter-test.php';
    }

    protected function tearDown()
    {
        if (file_exists(sys_get_temp_dir().'/symfony-cache')) {
            FilesystemAdapterTest::rmdir(sys_get_temp_dir().'/symfony-cache');
        }
    }

    public function createCachePool($defaultLifetime = 0)
    {
        return new PhpArrayAdapter(self::$file, new FilesystemAdapter('php-array-fallback', $defaultLifetime));
    }
}