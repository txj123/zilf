<?php

namespace Zilf\Debug;

use Symfony\Component\Debug\BufferingLogger;
use Zilf\System\Zilf;

class WritingLogger extends BufferingLogger
{
    public function log($level, $message, array $context = array())
    {
        Zilf::$app->get('log')->error($message, array($level, $context));
    }
}
