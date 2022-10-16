<?php

namespace Trulyao\PhpStarter\Exceptions;

class HTTPException extends \Exception
{
    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }
}