<?php
/**
 * @link      http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license   http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\base;

/**
 * NotSupportedException represents an exception caused by accessing features that are not supported.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class NotSupportedException extends Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return 'Not Supported';
    }
}
