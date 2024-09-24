<?php

namespace App\Domains\Solicitation\Exceptions;

use Exception;

class CannotDeleteSolicitationException extends Exception
{
    public function __construct(?Exception $previous = null)
    {
        $message = __('custom.cannot_delete_solicitation');
        $code = 422;

        parent::__construct($message, $code, $previous);
    }
}
