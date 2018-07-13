<?php
/**
 * @link http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\base;

use Zilf\System\Zilf;

/**
 * Object is the base class that implements the *property* feature.
 *
 * It has been replaced by [[BaseObject]] in version 2.0.13 because `object` has become a reserved word which can not be
 * used as class name in PHP 7.2.
 *
 * Please refer to [[BaseObject]] for detailed documentation and to the
 * [UPGRADE notes](https://github.com/Zilfsoft/Zilf2/blob/2.0.13/framework/UPGRADE.md#upgrade-from-Zilf-2012)
 * on how to migrate your application to use [[BaseObject]] class to make your application compatible with PHP 7.2.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 * @deprecated since 2.0.13, the class name `Object` is invalid since PHP 7.2, use [[BaseObject]] instead.
 * @see https://wiki.php.net/rfc/object-typehint
 * @see https://github.com/Zilfsoft/Zilf2/issues/7936#issuecomment-315384669
 */
class Object extends BaseObject
{
}
