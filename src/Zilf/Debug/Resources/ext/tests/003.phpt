--TEST--
Test ErrorHandler in case of fatal error
--SKIPIF--
<?php if (!extension_loaded("symfony_debug")) print "skip"; ?>
--FILE--
<?php

namespace Psr\Log;

class LogLevel
{
    const EMERGENCY = 'emergency';
    const ALERT = 'alert';
    const CRITICAL = 'critical';
    const ERROR = 'error';
    const WARNING = 'warning';
    const NOTICE = 'notice';
    const INFO = 'info';
    const DEBUG = 'debug';
}

namespace Zilf\Debug;

$dir = __DIR__.'/../../../';
require $dir.'ErrorHandler.php';
require $dir.'Exception/FatalErrorException.php';
require $dir.'Exception/UndefinedFunctionException.php';
require $dir.'FatalErrorHandler/FatalErrorHandlerInterface.php';
require $dir.'FatalErrorHandler/ClassNotFoundFatalErrorHandler.php';
require $dir.'FatalErrorHandler/UndefinedFunctionFatalErrorHandler.php';
require $dir.'FatalErrorHandler/UndefinedMethodFatalErrorHandler.php';

function bar()
{
    foo();
}

function foo()
{
    notexist();
}

$handler = ErrorHandler::register();
$handler->setExceptionHandler('print_r');

if (function_exists('xdebug_disable')) {
    xdebug_disable();
}

bar();
?>
--EXPECTF--
Fatal error: Call to undefined function Zilf\Debug\notexist() in %s on line %d
Zilf\Debug\Exception\UndefinedFunctionException Object
(
    [message:protected] => Attempted to call function "notexist" from namespace "Zilf\Debug".
    [string:Exception:private] => 
    [code:protected] => 0
    [file:protected] => %s
    [line:protected] => %d
    [trace:Exception:private] => Array
        (
            [0] => Array
                (
%A                    [function] => Zilf\Debug\foo
%A                    [args] => Array
                        (
                        )

                )

            [1] => Array
                (
%A                    [function] => Zilf\Debug\bar
%A                    [args] => Array
                        (
                        )

                )
%A
        )

    [previous:Exception:private] => 
    [severity:protected] => 1
)
