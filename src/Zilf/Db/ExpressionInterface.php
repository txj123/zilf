<?php
/**
 * @link      http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license   http://www.Zilfframework.com/license/
 */

namespace Zilf\Db;

/**
 * Interface ExpressionInterface should be used to mark classes, that should be built
 * in a special way.
 *
 * The database abstraction layer of Zilf framework supports objects that implement this
 * interface and will use [[ExpressionBuilderInterface]] to build them.
 *
 * The default implementation is a class [[Expression]].
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since  2.0.14
 */
interface ExpressionInterface
{
}
