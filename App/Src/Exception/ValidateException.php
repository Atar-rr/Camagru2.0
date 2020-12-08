<?php

namespace App\Src\Exception;

use Exception;

class ValidateException extends Exception
{
    public function __construct(?string $message = null, ?int $httpCode = null, ?string $extendedMessage = null)
    {
        parent::__construct($message, $httpCode, $extendedMessage);
    }
}
