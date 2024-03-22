<?php

namespace Database\Seeders\Data;

use App\Domains\Solicitation\Enums\SolicitationCategoriesEnum;

class SolicitationCategoriesData
{
    public static function getSolicitationCategoriesData(): array
    {
        return [
            SolicitationCategoriesEnum::ACCESSIBILITY_ISSUES => [
                'name' => SolicitationCategoriesEnum::ACCESSIBILITY_ISSUES,
                'description' => 'Compreende todos os problemas que envolvem a acessibilidade de pessoas com deficiência como rampas de acesso ou em calçadas, falta de piso tátil direcional, entre outros.'
            ],
        ];
    }
}
