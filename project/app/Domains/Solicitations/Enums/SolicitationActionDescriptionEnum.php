<?php

namespace App\Domains\Solicitations\Enums;

enum SolicitationActionDescriptionEnum: string
{
    case CREATED = 'created';

    case UPDATED = 'updated';

    case STATUS_UPDATED = 'status_updated';

    case LIKED = 'liked';

    case DELETED = 'deleted';
}
