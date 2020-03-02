<?php

namespace EquineSolutions\IOCFilemaker\Exceptions;


use Throwable;
use Exception;

class FieldDoesNotExist extends Exception
{
public function __construct(string $message = "field doesn't exist", int $code = 422, Throwable $previous = null)
{
    parent::__construct($message, $code, $previous);
}
}