<?php

namespace Zilf\Console;

use Closure;
use Exception;
use Throwable;
use ReflectionClass;
use Zilf\Console\Command;
use Symfony\Component\Finder\Finder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Foundation\Application;
use Zilf\Console\Application as Artisan;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Zilf\Di\Container;
use Zilf\Helpers\Arr;
use Zilf\Helpers\Str;
use Zilf\System\Zilf;

class Kernel
{
    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The event dispatcher implementation.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * The Artisan application instance.
     *
     * @var \Zilf\Console\Application
     */
    protected $artisan;

    /**
     * The Artisan commands provided by the application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Indicates if the Closure commands have been loaded.
     *
     * @var bool
     */
    protected $commandsLoaded = false;


    /**
     * Create a new console kernel instance.
     *
     * Kernel constructor.
     *
     * @param $publicPath
     */
    public function __construct($publicPath)
    {
        new \Zilf\System\Application($publicPath);
    }

    /**
     * Run the console application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return int
     */
    public function handle($input, $output = null)
    {
        try {
            $this->bootstrap();

            return $this->getArtisan()->run($input, $output);
        } catch (Exception $e) {
            $this->reportException($e);

            $this->renderException($output, $e);

            return 1;
        } catch (Throwable $e) {
            $e = new FatalThrowableError($e);

            $this->reportException($e);

            $this->renderException($output, $e);

            return 1;
        }
    }

    /**
     * Terminate the application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @param  int                                             $status
     * @return void
     */
    public function terminate($input, $status)
    {
        //$this->app->terminate();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        //
    }

    /**
     * Register a Closure based command with the application.
     *
     * @param  string   $signature
     * @param  \Closure $callback
     * @return \Illuminate\Foundation\Console\ClosureCommand
     */
    public function command($signature, Closure $callback)
    {
        $command = new ClosureCommand($signature, $callback);

        Artisan::starting(
            function ($artisan) use ($command) {
                $artisan->add($command);
            }
        );

        return $command;
    }

    /**
     * Register all of the commands in the given directory.
     *
     * @param  array|string $paths
     * @return void
     */
    protected function load($paths)
    {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter(
            $paths, function ($path) {
                return is_dir($path);
            }
        );

        if (empty($paths)) {
            return;
        }

        $namespace = 'App\\';

        foreach ((new Finder)->in($paths)->files() as $command) {
            $command = $namespace . str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($command->getPathname(), app_path() . DIRECTORY_SEPARATOR)
            );

            if (is_subclass_of($command, Command::class) 
                && !(new ReflectionClass($command))->isAbstract()
            ) {

                Zilf::$container->register($command, $command);

                Artisan::starting(
                    function ($artisan) use ($command) {
                        $artisan->resolve($command);
                    }
                );
            }
        }
    }

    /**
     * Register the given command with the console application.
     *
     * @param  \Symfony\Component\Console\Command\Command $command
     * @return void
     */
    public function registerCommand($command)
    {
        $this->getArtisan()->add($command);
    }

    /**
     * Run an Artisan console command by name.
     *
     * @param  string                                            $command
     * @param  array                                             $parameters
     * @param  \Symfony\Component\Console\Output\OutputInterface $outputBuffer
     * @return int
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        $this->bootstrap();

        return $this->getArtisan()->call($command, $parameters, $outputBuffer);
    }

    /**
     * Get all of the commands registered with the console.
     *
     * @return array
     */
    public function all()
    {
        $this->bootstrap();

        return $this->getArtisan()->all();
    }

    /**
     * Get the output for the last run command.
     *
     * @return string
     */
    public function output()
    {
        $this->bootstrap();

        return $this->getArtisan()->output();
    }

    /**
     * Bootstrap the application for artisan commands.
     *
     * @return void
     */
    public function bootstrap()
    {
        if (!$this->commandsLoaded) {

            $this->commands();

            $this->commandsLoaded = true;
        }
    }

    /**
     * Get the Artisan application instance.
     *
     * @return \Zilf\Console\Application
     */
    protected function getArtisan()
    {
        if (is_null($this->artisan)) {
            return $this->artisan = (new Artisan(Zilf::$version))
                ->resolveCommands($this->commands);
        }

        return $this->artisan;
    }

    /**
     * Set the Artisan application instance.
     *
     * @param  \Zilf\Console\Application $artisan
     * @return void
     */
    public function setArtisan($artisan)
    {
        $this->artisan = $artisan;
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Exception $e
     * @return void
     */
    protected function reportException(Exception $e)
    {
        throw $e;
        // $this->app[ExceptionHandler::class]->report($e);
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  \Exception                                        $e
     * @return void
     */
    protected function renderException($output, Exception $e)
    {
        $this->app[ExceptionHandler::class]->renderForConsole($output, $e);
    }
}
