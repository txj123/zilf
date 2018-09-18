<?php
/**
 * @link http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license http://www.Zilfframework.com/license/
 */

namespace Zilf\Db;

use Zilf\Db\base\BaseObject;

/**
 * Constraint represents the metadata of a table constraint.
 *
 * @author Sergey Makinen <sergey@makinen.ru>
 * @since 2.0.13
 */
class Constraint extends BaseObject
{
    /**
     * @var string[]|null list of column names the constraint belongs to.
     */
    public $columnNames;
    /**
     * @var string|null the constraint name.
     */
    public $name;
}
