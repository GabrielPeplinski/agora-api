<?php

namespace App\Domains\Solicitation\Actions\SolicitationCategory;

use App\Domains\Solicitation\Models\SolicitationCategory;

class CreateSolicitationCategoryAction
{
    public function execute(array $data): SolicitationCategory
    {
        return app(SolicitationCategory::class)
            ->create($data);
    }
}
