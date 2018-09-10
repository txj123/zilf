<?php
/**
 * @link      http://www.Zilfframework.com/
 * @copyright Copyright (c) 2008 Zilf Software LLC
 * @license   http://www.Zilfframework.com/license/
 */

namespace Zilf\Db\base;

/**
 * ModelEvent represents the parameter needed by [[Model]] events.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class ModelEvent extends Event
{
    /**
     * @var bool whether the model is in valid status. Defaults to true.
     * A model is in valid status if it passes validations or certain checks.
     */
    public $isValid = true;
}
