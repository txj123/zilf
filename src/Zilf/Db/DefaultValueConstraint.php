<?php
/**
 * @link      http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license   http://www.Zilfframework.com/license/
 */

namespace Zilf\Db;

/**
 * DefaultValueConstraint represents the metadata of a table `DEFAULT` constraint.
 *
 * @author Sergey Makinen <sergey@makinen.ru>
 * @since  2.0.13
 */
class DefaultValueConstraint extends Constraint
{
    /**
     * @var mixed default value as returned by the DBMS.
     */
    public $value;
}
