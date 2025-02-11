<?php

namespace App\Domains\Solicitation\Dtos;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class RemoveSolicitationImageData extends Data
{
    public function __construct(
        #[Required, ArrayType]
        public array $imageUrls,
    ) {}
}
