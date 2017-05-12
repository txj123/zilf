<?php

namespace Zilf\Debug\Exceptions;

/**
 * Undefined Function Exception.
 *
 * @author Konstanton Myakshin <koc-dp@yandex.ru>
 */
class UndefinedFunctionException extends FatalErrorException
{
    public function __construct($message, \ErrorException $previous)
    {
        parent::__construct(
            $message,
            $previous->getCode(),
            $previous->getSeverity(),
            $previous->getFile(),
            $previous->getLine(),
            $previous->getPrevious()
        );
        $this->setTrace($previous->getTrace());
    }
}
