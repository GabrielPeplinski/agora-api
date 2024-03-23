<?php

namespace App\Domains\Solicitation\Dtos;

use App\Domains\Solicitation\Enums\SolicitationStatusEnum;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class SolicitationData extends Data
{
    public function __construct(
        #[Required, StringType, Min(5), Max(255)]
        public string $title,

        #[Required, StringType, Min(5), Max(2000)]
        public string $report,

        #[Required, StringType, Regex('/^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/')]
        public string $latitudeCoordinate,

        #[Required, StringType, Regex('/^[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$/')]
        public string $longitudeCoordinate,

        #[Required, StringType, In([
            SolicitationStatusEnum::OPEN,
            SolicitationStatusEnum::RESOLVED,
            SolicitationStatusEnum::IN_PROGRESS,
        ])]
        public string $status,

        #[Required, IntegerType, Exists('users', 'id')]
        public int $userId,

        #[Required, IntegerType, Exists('solicitation_categories', 'id')]
        public int $solicitationCategoryId,
    ) {
    }
}
