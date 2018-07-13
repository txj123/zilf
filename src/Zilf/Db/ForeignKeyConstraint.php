<?php
/**
 * @link http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license http://www.Zilfframework.com/license/
 */

namespace Zilf\Db;

/**
 * ForeignKeyConstraint represents the metadata of a table `FOREIGN KEY` constraint.
 *
 * @author Sergey Makinen <sergey@makinen.ru>
 * @since 2.0.13
 */
class ForeignKeyConstraint extends Constraint
{
    /**
     * @var string|null referenced table schema name.
     */
    public $foreignSchemaName;
    /**
     * @var string referenced table name.
     */
    public $foreignTableName;
    /**
     * @var string[] list of referenced table column names.
     */
    public $foreignColumnNames;
    /**
     * @var string|null referential action if rows in a referenced table are to be updated.
     */
    public $onUpdate;
    /**
     * @var string|null referential action if rows in a referenced table are to be deleted.
     */
    public $onDelete;
}
