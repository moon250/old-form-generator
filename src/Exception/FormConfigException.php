<?php

namespace FormGenerator\Exception;

use Exception;

class FormConfigException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct();
        $this->message = $message;
    }
}
