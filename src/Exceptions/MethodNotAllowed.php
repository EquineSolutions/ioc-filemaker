<?php

namespace EquineSolutions\IOCFilemaker\Exceptions;


use Throwable;
use Exception;

class MethodNotAllowed extends Exception
{
    public function __construct(string $message = "you can't call this method on this layout", int $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}