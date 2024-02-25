<?php

namespace App\Domains\Account\Actions\AddressState;

use App\Domains\Account\Models\AddressState;

class GetAddressStateIdByAbbreviationAction
{
    public function execute(string $abbreviation): ?int
    {
        $state = app(AddressState::class)
            ->where('name_abbreviation', $abbreviation)
            ->select('id')
            ->first();

        return $state ? $state->id : null;
    }
}
