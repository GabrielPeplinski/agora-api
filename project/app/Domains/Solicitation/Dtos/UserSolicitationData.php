<?php

namespace App\Domains\Solicitation\Dtos;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class UserSolicitationData extends Data
{
    public function __construct(
        #[Nullable, IntegerType, Exists('solicitations', 'id')]
        public ?int $solicitationId,

        #[Nullable, IntegerType, Exists('users', 'id')]
        public ?int $userId,

        #[Nullable, StringType, Min(1), Max(255)]
        public ?string $status,

        #[Nullable, StringType, Min(4), Max(255)]
        public ?string $actionDescription,
    ) {
    }
}
