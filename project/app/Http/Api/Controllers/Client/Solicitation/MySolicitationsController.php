<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Resources\Client\Solicitation\SolicitationResource;
use App\Support\PaginationBuilder;

class MySolicitationsController
{
    public function __invoke()
    {
        $mySolicitations = app(Solicitation::class)
            ->whereHas('usersSolicitations', function ($query) {
                $query->where('user_id', current_user()->id)
                    ->where('status', SolicitationActionDescriptionEnum::CREATED);
            })->get();

        return PaginationBuilder::for($mySolicitations)
            ->resource(SolicitationResource::class);
    }
}
