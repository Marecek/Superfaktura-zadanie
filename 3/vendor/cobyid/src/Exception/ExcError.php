<?php

namespace CoById\Exception;

use ErrorException;

class ExcError extends ErrorException
{
    /**
     * @param int $code
     * @param string|null $message
     */
    public function __construct(int $code, ?string $message = null)
    {
        parent::__construct($message, $code);
    }
}
