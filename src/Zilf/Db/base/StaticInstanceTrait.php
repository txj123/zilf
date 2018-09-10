<?php
/**
 * @link      http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license   http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\base;

use Zilf\System\Zilf;

/**
 * StaticInstanceTrait provides methods to satisfy [[StaticInstanceInterface]] interface.
 *
 * @see StaticInstanceInterface
 *
 * @author Paul Klimov <klimov.paul@gmail.com>
 * @since  2.0.13
 */
trait StaticInstanceTrait
{
    /**
     * @var static[] static instances in format: `[className => object]`
     */
    private static $_instances = [];


    /**
     * Returns static class instance, which can be used to obtain meta information.
     *
     * @param  bool $refresh whether to re-create static instance even, if it is already cached.
     * @return static class instance.
     */
    public static function instance($refresh = false)
    {
        $className = get_called_class();
        if ($refresh || !isset(self::$_instances[$className])) {
            self::$_instances[$className] = Zilf::createObject($className);
        }
        return self::$_instances[$className];
    }
}
