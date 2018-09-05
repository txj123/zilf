<?php

namespace Zilf\Debug;

use Symfony\Component\Debug\BufferingLogger;
use Symfony\Component\Debug\DebugClassLoader;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Zilf\System\Zilf;

class Debug
{
    private static $enabled = false;

    /**
     * Enables the debug tools.
     *
     * This method registers an error handler and an exception handler.
     *
     * @param int  $errorReportingLevel The level of error reporting you want
     * @param bool $displayErrors       Whether to display errors (for development) or just log them (for production)
     */
    public static function enable($errorReportingLevel = E_ALL, $displayErrors = true)
    {
        if (static::$enabled) {
            return;
        }

        static::$enabled = true;

        if (null !== $errorReportingLevel) {
            error_reporting($errorReportingLevel);
        } else {
            error_reporting(E_ALL);
        }

        if (!\in_array(\PHP_SAPI, array('cli', 'phpdbg'), true)) {

            ini_set('display_errors', 0);
            ExceptionHandler::register(config('app.debug'));

        } elseif ($displayErrors && (!ini_get('log_errors') || ini_get('error_log'))) {

            // CLI - display errors only if they're not already logged to STDERR
            ini_set('display_errors', 1);

        }

        if ($displayErrors) {
            ErrorHandler::register(new ErrorHandler(new WritingLogger()));
        } else {
            ErrorHandler::register()->throwAt(0, true);
        }

        DebugClassLoader::enable();
    }
}
