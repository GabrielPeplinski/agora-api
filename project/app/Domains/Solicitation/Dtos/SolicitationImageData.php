<?php

namespace App\Domains\Solicitation\Dtos;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\In;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;

class SolicitationImageData extends Data
{
    public function __construct(
        #[Required, IntegerType, Exists('solicitations', 'id')]
        public string $solicitationId,

        #[Required, StringType, Min(5), Max(255)]
        public string $fileName,

        #[Required, StringType, Min(5), Max(255)]
        public string $filePath,

        #[Required, BooleanType, In([true, false])]
        public bool   $isCoverImage = false,
    )
    {
    }
}
