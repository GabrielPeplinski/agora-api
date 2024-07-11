<?php

namespace App\Domains\Solicitation\Enums;

enum SolicitationStatusEnum: string
{
    public const OPEN = 'open';

    public const IN_PROGRESS = 'in_progress';

    public const RESOLVED = 'resolved';
}
