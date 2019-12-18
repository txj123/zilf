<?php

namespace Zilf\Facades;

use Zilf\System\Bus\PendingDispatch;

/**
 * @method static int handle(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output = null)
 * @method static int call(string $command, array $parameters = [], $outputBuffer = null)
 * @method static PendingDispatch queue(string $command, array $parameters = [])
 * @method static array all()
 * @method static string output()
 *
 * @see \Zilf\Console\Kernel
 */
class Txj extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'consoleKernel';
    }
}
