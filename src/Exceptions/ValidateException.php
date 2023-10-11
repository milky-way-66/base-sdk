<?php

namespace MilkyWay\BaseSdk\Exceptions;

use Exception;

class ValidateException extends Exception
{
    public function __construct($message = "validate exception", $code = 422)
    {
        parent::__construct(message: $message, code: $code);
    }
}