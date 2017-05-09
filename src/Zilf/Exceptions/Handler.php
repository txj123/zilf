<?php

namespace Zilf\Exceptions;

use Exception;
use Psr\Log\LoggerInterface;
use Zilf\Debug\Exception\FlattenException;
use Zilf\Debug\ExceptionHandler;
use Zilf\HttpFoundation\RedirectResponse;
use Zilf\HttpFoundation\Response;
use Zilf\System\Zilf;

class Handler
{
    /**
     * Report or log an exception.
     *
     * @param  \Exception  $e
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $e)
    {
        $logger = Zilf::$container['log'];
        $logger->error($e);
    }

    /**
     * Render an exception into a response.
     *
     * @param $request
     * @param Exception $e
     * @return \Zilf\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        $e = $this->prepareException($e);

        if ($e instanceof HttpResponseException) {
            return $e->getResponse();
        }

        return $this->prepareResponse($request, $e);
    }

    /**
     * Prepare exception for rendering.
     *
     * @param  \Exception  $e
     * @return \Exception
     */
    protected function prepareException(Exception $e)
    {
        if ($e instanceof AuthorizationException) {
            $e = new HttpException(403, $e->getMessage());
        }

        return $e;
    }

    /**
     * Prepare response containing exception render.
     *
     * @param $request
     * @param Exception $e
     * @return \Zilf\HttpFoundation\Response
     */
    protected function prepareResponse($request, Exception $e)
    {
        if ($this->isHttpException($e)) {
            return $this->toIlluminateResponse($this->renderHttpException($e), $e);
        } else {
            return $this->toIlluminateResponse($this->convertExceptionToResponse($e), $e);
        }
    }

    /**
     * Render the given HttpException.
     *
     * @param HttpException $e
     * @return \Zilf\HttpFoundation\Response
     */
    protected function renderHttpException(HttpException $e)
    {
        $status = $e->getStatusCode();

       /* view()->replaceNamespace('errors', [
            resource_path('views/errors'),
            __DIR__.'/views',
        ]);

        if (view()->exists("errors::{$status}")) {
            return response()->view("errors::{$status}", ['exception' => $e], $status, $e->getHeaders());
        } else {*/
            return $this->convertExceptionToResponse($e);
//        }
    }

    /**
     * Create a Symfony response for the given exception.
     *
     * @param  \Exception  $e
     * @return \Zilf\HttpFoundation\Response
     */
    protected function convertExceptionToResponse(Exception $e)
    {
        $e = FlattenException::create($e);

        $handler = new ExceptionHandler(APP_DEBUG);

        return Response::create($handler->getHtml($e), $e->getStatusCode(), $e->getHeaders());
    }

    /**
     * Map the given exception into an Illuminate response.
     *
     * @param  \Zilf\HttpFoundation\Response  $response
     * @param  \Exception  $e
     * @return \Zilf\HttpFoundation\Response
     */
    protected function toIlluminateResponse($response, Exception $e)
    {
        if ($response instanceof RedirectResponse) {
            $response = new RedirectResponse($response->getTargetUrl(), $response->getStatusCode(), $response->headers->all());
        } else {
            $response = new Response($response->getContent(), $response->getStatusCode(), $response->headers->all());
        }

        return $response;
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Exception  $e
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        (new ConsoleApplication)->renderException($e, $output);
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param  \Exception  $e
     * @return bool
     */
    protected function isHttpException(Exception $e)
    {
        return $e instanceof HttpException;
    }
}
