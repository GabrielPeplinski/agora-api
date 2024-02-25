<?php

namespace Database\Seeders;

use App\Domains\Account\Models\AddressState;
use Illuminate\Database\Seeder;

class AddressStatesSeeder extends Seeder
{
    public function run(): void
    {
        $statesData = [
            'AC' => [
                'name' => 'Acre',
                'name_abbreviation' => 'AC',
            ],
            'AL' => [
                'name' => 'Alagoas',
                'name_abbreviation' => 'AL',
            ],
            'AP' => [
                'name' => 'Amapá',
                'name_abbreviation' => 'AP',
            ],
            'AM' => [
                'name' => 'Amazonas',
                'name_abbreviation' => 'AM',
            ],
            'BA' => [
                'name' => 'Bahia',
                'name_abbreviation' => 'BA',
            ],
            'CE' => [
                'name' => 'Ceará',
                'name_abbreviation' => 'CE',
            ],
            'DF' => [
                'name' => 'Distrito Federal',
                'name_abbreviation' => 'DF',
            ],
            'ES' => [
                'name' => 'Espírito Santo',
                'name_abbreviation' => 'ES',
            ],
            'GO' => [
                'name' => 'Goiás',
                'name_abbreviation' => 'GO',
            ],
            'MA' => [
                'name' => 'Maranhão',
                'name_abbreviation' => 'MA',
            ],
            'MT' => [
                'name' => 'Mato Grosso',
                'name_abbreviation' => 'MT',
            ],
            'MS' => [
                'name' => 'Mato Grosso do Sul',
                'name_abbreviation' => 'MS',
            ],
            'MG' => [
                'name' => 'Minas Gerais',
                'name_abbreviation' => 'MG',
            ],
            'PA' => [
                'name' => 'Pará',
                'name_abbreviation' => 'PA',
            ],
            'PB' => [
                'name' => 'Paraíba',
                'name_abbreviation' => 'PB',
            ],
            'PR' => [
                'name' => 'Paraná',
                'name_abbreviation' => 'PR',
            ],
            'PE' => [
                'name' => 'Pernambuco',
                'name_abbreviation' => 'PE',
            ],
            'PI' => [
                'name' => 'Piauí',
                'name_abbreviation' => 'PI',
            ],
            'RJ' => [
                'name' => 'Rio de Janeiro',
                'name_abbreviation' => 'RJ',
            ],
            'RN' => [
                'name' => 'Rio Grande do Norte',
                'name_abbreviation' => 'RN',
            ],
            'RS' => [
                'name' => 'Rio Grande do Sul',
                'name_abbreviation' => 'RS',
            ],
            'RO' => [
                'name' => 'Rondônia',
                'name_abbreviation' => 'RO',
            ],
            'RR' => [
                'name' => 'Roraima',
                'name_abbreviation' => 'RR',
            ],
            'SC' => [
                'name' => 'Santa Catarina',
                'name_abbreviation' => 'SC',
            ],
            'SP' => [
                'name' => 'São Paulo',
                'name_abbreviation' => 'SP',
            ],
            'SE' => [
                'name' => 'Sergipe',
                'name_abbreviation' => 'SE',
            ],
            'TO' => [
                'name' => 'Tocantins',
                'name_abbreviation' => 'TO',
            ]
        ];

        foreach ($statesData as $stateData) {
            app(AddressState::class)
                ->create([
                    'name' => $stateData['name'],
                    'name_abbreviation' => $stateData['name_abbreviation'],
                ]);
        }
    }
}
