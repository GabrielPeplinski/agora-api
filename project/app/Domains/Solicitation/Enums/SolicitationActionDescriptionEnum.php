<?php

namespace App\Domains\Solicitation\Enums;

enum SolicitationActionDescriptionEnum: string
{
    public const CREATED = 'created';

    public const UPDATED = 'updated';

    public const STATUS_UPDATED = 'status_updated';

    public const LIKE = 'like';

    public const DELETED = 'deleted';
}
