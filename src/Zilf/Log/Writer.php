<?php

namespace Zilf\Log;

use Closure;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Logger;
use RuntimeException;
use InvalidArgumentException;
use Monolog\Handler\SyslogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;

use Zilf\System\Zilf;

class Writer
{
    /**
     * The Monolog logger instance.
     *
     * @var \Monolog\Logger
     */
    protected $monolog;


    /**
     * The Log levels.
     *
     * @var array
     */
    protected $levels = [
        'debug' => MonologLogger::DEBUG,
        'info' => MonologLogger::INFO,
        'notice' => MonologLogger::NOTICE,
        'warning' => MonologLogger::WARNING,
        'error' => MonologLogger::ERROR,
        'critical' => MonologLogger::CRITICAL,
        'alert' => MonologLogger::ALERT,
        'emergency' => MonologLogger::EMERGENCY,
    ];

    /**
     * Writer constructor.
     * @param array $monologConfig
     * @param string $runtimePath
     */
    public function __construct($monologConfig, $runtimePath)
    {
        $handlers = $monologConfig['handlers'];
        $filename = date('Y-m-d') . '_' . Zilf::$app->getEnvironment() . '.log';

        $logger = new Logger('logger'); //Zilf::$container->get('logger');
        foreach ($handlers as $row) {
            $handler = isset($row['type']) ? $row['type'] : 'StreamHandler';
            $level = isset($row['level']) ? $row['level'] : 'debug';
            if ($handler == 'StreamHandler') {
                $handObj = new StreamHandler($runtimePath . '/logs/' . $filename, $this->parseLevel($level));
            } else {
                $handObj = new $handler($this->levels[$level]);
            }
            $logger->pushHandler($handObj);
        }

        $this->monolog = $logger;
    }

    /**
     * Log an emergency message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function emergency($message, array $context = [])
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an alert message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function alert($message, array $context = [])
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a critical message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function critical($message, array $context = [])
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an error message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function error($message, array $context = [])
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function warning($message, array $context = [])
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function notice($message, array $context = [])
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function info($message, array $context = [])
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function debug($message, array $context = [])
    {
        return $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a message to the logs.
     *
     * @param  string $level
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function log($level, $message, array $context = [])
    {
        return $this->writeLog($level, $message, $context);
    }

    /**
     * Dynamically pass log calls into the writer.
     *
     * @param  string $level
     * @param  string $message
     * @param  array $context
     * @return mixed
     */
    public function write($level, $message, array $context = [])
    {
        return $this->writeLog($level, $message, $context);
    }

    /**
     * @param $level
     * @param $message
     * @param $context
     * @return mixed
     */
    protected function writeLog($level, $message, $context)
    {
        return $this->monolog->{$level}($message, $context);
    }

    /**
     * Register a file log handler.
     *
     * @param  string $path
     * @param  string $level
     * @return void
     */
    public function useFiles($path, $level = 'debug')
    {
        $this->monolog->pushHandler($handler = new StreamHandler($path, $this->parseLevel($level)));

        $handler->setFormatter($this->getDefaultFormatter());
    }

    /**
     * Register a daily file log handler.
     *
     * @param  string $path
     * @param  int $days
     * @param  string $level
     * @return void
     */
    public function useDailyFiles($path, $days = 0, $level = 'debug')
    {
        $this->monolog->pushHandler(
            $handler = new RotatingFileHandler($path, $days, $this->parseLevel($level))
        );

        $handler->setFormatter($this->getDefaultFormatter());
    }

    /**
     * Register a Syslog handler.
     *
     * @param  string $name
     * @param  string $level
     * @return \Psr\Log\LoggerInterface
     */
    public function useSyslog($name = 'laravel', $level = 'debug')
    {
        return $this->monolog->pushHandler(new SyslogHandler($name, LOG_USER, $level));
    }

    /**
     * Register an error_log handler.
     *
     * @param  string $level
     * @param  int $messageType
     * @return void
     */
    public function useErrorLog($level = 'debug', $messageType = ErrorLogHandler::OPERATING_SYSTEM)
    {
        $this->monolog->pushHandler(
            $handler = new ErrorLogHandler($messageType, $this->parseLevel($level))
        );

        $handler->setFormatter($this->getDefaultFormatter());
    }


    /**
     * Parse the string level into a Monolog constant.
     *
     * @param  string $level
     * @return int
     *
     * @throws \InvalidArgumentException
     */
    protected function parseLevel($level)
    {
        if (isset($this->levels[$level])) {
            return $this->levels[$level];
        }

        throw new InvalidArgumentException('Invalid log level.');
    }

    /**
     * Get the underlying Monolog instance.
     *
     * @return \Monolog\Logger
     */
    public function getMonolog()
    {
        return $this->monolog;
    }

    /**
     * Get a defaut Monolog formatter instance.
     *
     * @return \Monolog\Formatter\LineFormatter
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter(null, null, true, true);
    }
}
