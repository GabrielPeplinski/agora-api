<?php

namespace Database\Seeders;

use App\Domains\Solicitation\Actions\SolicitationCategory\CreateSolicitationCategoryAction;
use Database\Seeders\Data\SolicitationCategoriesData;
use Illuminate\Database\Seeder;

class SolicitationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $solicitationCategories = SolicitationCategoriesData::getSolicitationCategoriesData();

        foreach ($solicitationCategories as $solicitationCategory) {
            app(CreateSolicitationCategoryAction::class)
                ->execute($solicitationCategory);
        }
    }
}
