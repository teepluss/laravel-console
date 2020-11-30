<?php namespace Teepluss\Console;

use Throwable;
use Monolog\Handler\BrowserConsoleHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use App, Request, Response;

class Handler extends ExceptionHandler {

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        Console::addProfile('error', array(
            'type'    => $e->getCode(),
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ));

        return Response::json(Console::getProfile(), 200);
    }

}
