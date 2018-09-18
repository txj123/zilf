<?php

namespace Zilf\System\Bootstrap;

use Exception;
use SplFileInfo;
use Zilf\Config\Repository;
use Symfony\Component\Finder\Finder;
use Zilf\System\Zilf;

class LoadConfiguration
{
    /**
     * Bootstrap the given application.
     *
     * @return void
     */
    public function bootstrap()
    {
        $config = Zilf::$container->getShare('config');

        $this->loadConfigurationFiles($config);

        Zilf::$app->environment = $config->get('app.app_env');

        date_default_timezone_set($config->get('app.timezone', 'UTC'));

        mb_internal_encoding('UTF-8');
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param  \Zilf\Config\Repository $repository
     * @return void
     * @throws \Exception
     */
    protected function loadConfigurationFiles(Repository $repository)
    {
        $files = $this->getConfigurationFiles();

        if (!isset($files['app'])) {
            throw new Exception('Unable to load the "app" configuration file.');
        }

        foreach ($files as $key => $path) {
            $repository->set($key, include $path);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @return array
     */
    protected function getConfigurationFiles()
    {
        $files = [];

        $configPath = realpath(Zilf::$app->configPath());

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);

            $files[$directory . basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param  \SplFileInfo $file
     * @param  string       $configPath
     * @return string
     */
    protected function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested) . '.';
        }

        return $nested;
    }
}
