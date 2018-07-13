<?php
/**
 * @link http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\mssql;

/**
 * TableSchema represents the metadata of a database table.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TableSchema extends \Zilf\Db\TableSchema
{
    /**
     * @var string name of the catalog (database) that this table belongs to.
     * Defaults to null, meaning no catalog (or the current database).
     */
    public $catalogName;
}
