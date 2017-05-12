<?php

namespace Zilf\Debug\Exceptions;

/**
 * Undefined Method Exception.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class UndefinedMethodException extends FatalErrorException
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
