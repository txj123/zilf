<?php
/**
 * @link http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\conditions;

use Zilf\Db\base\InvalidArgumentException;

/**
 * Condition that inverts passed [[condition]].
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since 2.0.14
 */
class NotCondition implements ConditionInterface
{
    /**
     * @var mixed the condition to be negated
     */
    private $condition;


    /**
     * NotCondition constructor.
     *
     * @param mixed $condition the condition to be negated
     */
    public function __construct($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return mixed
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * {@inheritdoc}
     * @throws InvalidArgumentException if wrong number of operands have been given.
     */
    public static function fromArrayDefinition($operator, $operands)
    {
        if (count($operands) !== 1) {
            throw new InvalidArgumentException("Operator '$operator' requires exactly one operand.");
        }

        return new static(array_shift($operands));
    }
}
