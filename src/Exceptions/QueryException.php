<?php

namespace Trulyao\PhpStarter\Exceptions;

use Exception;

class QueryException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}