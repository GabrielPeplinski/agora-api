<?php

namespace App\Http\Api\Controllers\Shared;

use App\Domains\Solicitation\Models\Solicitation;
use App\Http\Api\Resources\Client\Solicitation\SolicitationResource;
use App\Http\Api\Resources\Shared\Solicitation\ShowSolicitationResource;
use App\Support\PaginationBuilder;

class SolicitationController
{
    public function index()
    {
        return PaginationBuilder::for(Solicitation::class)
            ->with([
                'images',
                'coverImage',
            ])
            ->resource(SolicitationResource::class);
    }

    public function show(Solicitation $solicitation)
    {
        return ShowSolicitationResource::make($solicitation);
    }
}
