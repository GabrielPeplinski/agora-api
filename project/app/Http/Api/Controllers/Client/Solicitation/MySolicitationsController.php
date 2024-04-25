<?php

namespace App\Http\Api\Controllers\Client\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Domains\Solicitation\Filters\SolicitationStatusFilter;
use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Resources\Client\Solicitation\SolicitationResource;
use App\Support\PaginationBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class MySolicitationsController
{
    public function __invoke()
    {
        $mySolicitations = app(Solicitation::class)
            ->whereHas('userSolicitations', function ($query) {
                $query->where('user_id', current_user()->id)
                    ->where('action_description', SolicitationActionDescriptionEnum::CREATED);
            });

        return PaginationBuilder::for($mySolicitations)
            ->allowedFilters([
                AllowedFilter::custom('status', new SolicitationStatusFilter()),
            ])
            ->resource(SolicitationResource::class);
    }
}
