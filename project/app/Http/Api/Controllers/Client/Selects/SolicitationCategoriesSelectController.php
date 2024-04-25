<?php

namespace App\Http\Api\Controllers\Client\Selects;

use App\Domains\Solicitation\Models\SolicitationCategory;
use App\Http\Api\Resources\Client\Selects\SolicitationCategorySelectResource;

class SolicitationCategoriesSelectController
{
    public function __invoke()
    {
        $solicitationCategories = app(SolicitationCategory::class)
            ->select('id', 'name', 'description')
            ->get();

        return SolicitationCategorySelectResource::collection($solicitationCategories);
    }
}
