<?php

namespace JuliaYatsko\course2\core\Exception;

class ErrorNotFoundException extends \Exception
{
    public function __construct($message = "Page not found", $code = 404)
    {
        parent::__construct($message, $code);
    }
}