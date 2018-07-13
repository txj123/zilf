<?php
/**
 * @link http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\base;

/**
 * InvalidParamException represents an exception caused by invalid parameters passed to a method.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 * @deprecated since 2.0.14. Use [[InvalidArgumentException]] instead.
 */
class InvalidParamException extends \BadMethodCallException
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Invalid Parameter';
    }
}
