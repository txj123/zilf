<?php
/**
 * @link      http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license   http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\pgsql;

use Zilf\Db\ArrayExpression;
use Zilf\Db\ExpressionBuilderInterface;
use Zilf\Db\ExpressionBuilderTrait;
use Zilf\Db\ExpressionInterface;
use Zilf\Db\JsonExpression;
use Zilf\Db\Query;
use Zilf\Helpers\Json;

/**
 * Class JsonExpressionBuilder builds [[JsonExpression]] for PostgreSQL DBMS.
 *
 * @author Dmytro Naumenko <d.naumenko.a@gmail.com>
 * @since  2.0.14
 */
class JsonExpressionBuilder implements ExpressionBuilderInterface
{
    use ExpressionBuilderTrait;


    /**
     * {@inheritdoc}
     *
     * @param JsonExpression|ExpressionInterface $expression the expression to be built
     */
    public function build(ExpressionInterface $expression, array &$params = [])
    {
        $value = $expression->getValue();

        if ($value instanceof Query) {
            list ($sql, $params) = $this->queryBuilder->build($value, $params);
            return "($sql)" . $this->getTypecast($expression);
        }
        if ($value instanceof ArrayExpression) {
            $placeholder = 'array_to_json(' . $this->queryBuilder->buildExpression($value, $params) . ')';
        } else {
            $placeholder = $this->queryBuilder->bindParam(Json::encode($value), $params);
        }

        return $placeholder . $this->getTypecast($expression);
    }

    /**
     * @param  JsonExpression $expression
     * @return string the typecast expression based on [[type]].
     */
    protected function getTypecast(JsonExpression $expression)
    {
        if ($expression->getType() === null) {
            return '';
        }

        return '::' . $expression->getType();
    }
}
