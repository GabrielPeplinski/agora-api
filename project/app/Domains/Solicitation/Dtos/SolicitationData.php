<?php

namespace App\Domains\Solicitation\Dtos;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class SolicitationData extends Data
{
    public function __construct(
        #[Required, StringType, Min(5), Max(255)]
        public string $title,

        #[Required, StringType, Min(5), Max(1000)]
        public string $description,

        #[Required, StringType, Min(1), Max(15)]
        public string $latitudeCoordinates,

        #[Required, StringType, Min(1), Max(15)]
        public string $longitudeCoordinates,

        #[Required, IntegerType, Exists('solicitation_categories', 'id')]
        public int $solicitationCategoryId,

        #[Nullable, IntegerType]
        public ?int $likesAmount,

        // UserSolicitation fields

        #[Nullable, IntegerType, Exists('solicitations', 'id')]
        public ?int $solicitationId,

        #[Nullable, IntegerType, Exists('users', 'id')]
        public ?int $userId,

        #[Nullable, StringType, Min(1), Max(255)]
        public ?string $status,

        #[Nullable, StringType, Min(5), Max(255)]
        public ?string $actionDescription,
    ) {
    }
}