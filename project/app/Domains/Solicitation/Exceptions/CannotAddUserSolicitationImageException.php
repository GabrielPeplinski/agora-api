<?php

namespace App\Domains\Solicitation\Exceptions;

use Exception;

class CannotAddUserSolicitationImageException extends Exception
{
    public function __construct(?Exception $previous = null)
    {
        $message = __('custom.invalid_action_description_to_add_image');
        $code = 422;

        parent::__construct($message, $code, $previous);
    }
}
