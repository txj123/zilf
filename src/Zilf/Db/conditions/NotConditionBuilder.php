<?php
/**
 * @link      http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license   http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\conditions;

use Zilf\Db\ExpressionBuilderInterface;
use Zilf\Db\ExpressionBuilderTrait;
use Zilf\Db\ExpressionInterface;

/**
 * Class NotConditionBuilder builds objects of [[NotCondition]]
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since  2.0.14
 */
class NotConditionBuilder implements ExpressionBuilderInterface
{
    use ExpressionBuilderTrait;


    /**
     * Method builds the raw SQL from the $expression that will not be additionally
     * escaped or quoted.
     *
     * @param  ExpressionInterface|NotCondition $expression the expression to be built.
     * @param  array                            $params     the binding parameters.
     * @return string the raw SQL that will not be additionally escaped or quoted.
     */
    public function build(ExpressionInterface $expression, array &$params = [])
    {
        $operand = $expression->getCondition();
        if ($operand === '') {
            return '';
        }

        $expession = $this->queryBuilder->buildCondition($operand, $params);
        return "{$this->getNegationOperator()} ($expession)";
    }

    /**
     * @return string
     */
    protected function getNegationOperator()
    {
        return 'NOT';
    }
}
