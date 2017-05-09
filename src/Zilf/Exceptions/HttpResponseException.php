<?php

namespace Zilf\Exceptions;

use RuntimeException;
use Zilf\HttpFoundation\Response;

class HttpResponseException extends RuntimeException
{
    /**
     * The underlying response instance.
     *
     * @var \Zilf\HttpFoundation\Response
     */
    protected $response;

    /**
     * Create a new HTTP response exception instance.
     *
     * @param  \Zilf\HttpFoundation\Response  $response
     * @return void
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Get the underlying response instance.
     *
     * @return \Zilf\HttpFoundation\Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}
