<?php

namespace Trulyao\PhpStarter\Middleware;

use Trulyao\PhpRouter\HTTP\Request;
use Trulyao\PhpRouter\HTTP\Response;

abstract class BaseMiddleware
{
    public function __invoke(Request $request, Response $response)
    {
        // Do something before the request is handled
        // You could use static methods instead of this magic method, but they do not need to extend this class
        // To use this, you just need to pass in an instance of the middleware class in the route
    }
}