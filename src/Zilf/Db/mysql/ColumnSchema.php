<?php
/**
 * @link      http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license   http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\mysql;

use Zilf\Db\ExpressionInterface;
use Zilf\Db\JsonExpression;

/**
 * Class ColumnSchema for MySQL database
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since  2.0.14.1
 */
class ColumnSchema extends \Zilf\Db\ColumnSchema
{
    /**
     * @var bool whether the column schema should OMIT using JSON support feature.
     * You can use this property to make upgrade to Zilf 2.0.14 easier.
     * Default to `false`, meaning JSON support is enabled.
     *
     * @since      2.0.14.1
     * @deprecated Since 2.0.14.1 and will be removed in 2.1.
     */
    public $disableJsonSupport = false;


    /**
     * {@inheritdoc}
     */
    public function dbTypecast($value)
    {
        if ($value === null) {
            return $value;
        }

        if ($value instanceof ExpressionInterface) {
            return $value;
        }

        if (!$this->disableJsonSupport && $this->dbType === Schema::TYPE_JSON) {
            return new JsonExpression($value, $this->type);
        }

        return $this->typecast($value);
    }

    /**
     * {@inheritdoc}
     */
    public function phpTypecast($value)
    {
        if ($value === null) {
            return null;
        }

        if (!$this->disableJsonSupport && $this->type === Schema::TYPE_JSON) {
            return json_decode($value, true);
        }

        return parent::phpTypecast($value);
    }
}
