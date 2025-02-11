<?php

namespace App\Domains\Solicitation\Exceptions;

use Exception;

class CannotUpdateSolicitationException extends Exception
{
    public function __construct(?Exception $previous = null)
    {
        $message = __('custom.cannot_update_solicitation');
        $code = 422;

        parent::__construct($message, $code, $previous);
    }
}
