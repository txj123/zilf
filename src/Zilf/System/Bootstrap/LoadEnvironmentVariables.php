<?php

namespace Zilf\System\Bootstrap;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Exception\InvalidPathException;
use Symfony\Component\Console\Input\ArgvInput;
use Zilf\System\Zilf;

class LoadEnvironmentVariables
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap()
    {
        $app = Zilf::$app;
        $this->checkForSpecificEnvironmentFile($app);

        try {
            (new Dotenv($app->environmentPath(), $app->environmentFile()))->load();
        } catch (InvalidPathException $e) {
            //
        } catch (InvalidFileException $e) {
            die('The environment file is invalid: ' . $e->getMessage());
        }
    }

    /**
     * Detect if a custom environment file matching the APP_ENV exists.
     *
     * @param  \Zilf\System\Application $app
     * @return void
     */
    protected function checkForSpecificEnvironmentFile($app)
    {
        if ($app->runningInConsole() && ($input = new ArgvInput)->hasParameterOption('--env')) {
            if ($this->setEnvironmentFilePath(
                $app, $app->environmentFile() . '.' . $input->getParameterOption('--env')
            )
            ) {
                return;
            }
        }

        if (!env('APP_ENV')) {
            return;
        }

        $this->setEnvironmentFilePath(
            $app, $app->environmentFile() . '.' . env('APP_ENV')
        );
    }

    /**
     * Load a custom environment file.
     *
     * @param  \Zilf\System\Application $app
     * @param  string                   $file
     * @return bool
     */
    protected function setEnvironmentFilePath($app, $file)
    {
        if (file_exists($app->environmentPath() . '/' . $file)) {
            $app->loadEnvironmentFrom($file);

            return true;
        }

        return false;
    }
}
