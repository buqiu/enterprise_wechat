<?php

namespace Buqiu\EnterpriseWechat\Exceptions;

use Exception;
use ReturnTypeWillChange;

class InternalError extends Exception
{
    public function __construct($message, $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    #[ReturnTypeWillChange]
    public function __toString()
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}