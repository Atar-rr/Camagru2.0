<?php


namespace App\Src\Exception;


class UserUnauthorizedException extends \Exception
{
    public function __construct(?string $message = null, ?int $httpCode = null, ?string $extendedMessage = null)
    {
        parent::__construct($message, $httpCode, $extendedMessage);
    }
}