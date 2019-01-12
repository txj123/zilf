<?php

namespace Zilf\Routing\Dispatch;

use Zilf\Routing\Dispatch;

class Callback extends Dispatch
{
    public function exec()
    {
        // 执行回调方法
        $vars = array_merge($this->request->param(), $this->param);

        return $this->app->invoke($this->dispatch, $vars);
    }

}
