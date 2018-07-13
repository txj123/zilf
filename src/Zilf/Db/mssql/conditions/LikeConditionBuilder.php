<?php
/**
 * @link http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\mssql\conditions;

/**
 * {@inheritdoc}
 */
class LikeConditionBuilder extends \Zilf\Db\conditions\LikeConditionBuilder
{
    /**
     * {@inheritdoc}
     */
    protected $escapingReplacements = [
        '%' => '[%]',
        '_' => '[_]',
        '[' => '[[]',
        ']' => '[]]',
        '\\' => '[\\]',
    ];
}
