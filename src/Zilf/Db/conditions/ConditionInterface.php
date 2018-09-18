<?php
/**
 * @link http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\conditions;

use Zilf\Db\base\InvalidParamException;
use Zilf\Db\ExpressionInterface;

/**
 * Interface ConditionInterface should be implemented by classes that represent a condition
 * in DBAL of framework.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since 2.0.14
 */
interface ConditionInterface extends ExpressionInterface
{
    /**
     * Creates object by array-definition as described in
     * [Query Builder – Operator format](guide:db-query-builder#operator-format) guide article.
     *
     * @param string $operator operator in uppercase.
     * @param array $operands array of corresponding operands
     *
     * @return $this
     * @throws InvalidParamException if input parameters are not suitable for this condition
     */
    public static function fromArrayDefinition($operator, $operands);
}
