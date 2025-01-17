<?php

namespace CoById\Exception;

use ErrorException;

class ExcError extends ErrorException
{
    /**
     * @param $code
     * @param $message
     */
    public function __construct($code, $message = null)
    {
        parent::__construct($message, $code);
    }
}
