<?php

namespace App\Domains\Account\Dtos;

use Spatie\LaravelData\Attributes\Validation\Exists;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AddressData extends Data
{
    public function __construct(
        #[Required, StringType, Min(8), Max(8)]
        public string|Optional $zipCode,

        #[Required, StringType]
        public string|Optional $neighborhood,

        #[Required, StringType]
        public string|Optional $cityName,

        #[Required, StringType]
        public string|Optional $stateName,

        #[Required, StringType]
        public string|Optional $stateAbbreviation,

        #[Nullable, IntegerType, Exists('address_states', 'id')]
        public ?int $addressStateId,

        #[Nullable, IntegerType, Exists('address_cities', 'id')]
        public ?int $addressCityId,
    ) {
    }
}
