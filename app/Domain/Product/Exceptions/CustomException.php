<?php

namespace App\Domain\Product\Exceptions;

use Exception;
use Throwable;

class CustomException extends Exception
{
    public function __construct($message = '', $code = 500, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
