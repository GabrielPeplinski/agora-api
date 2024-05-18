<?php

namespace Database\Seeders;

use App\Domains\Solicitation\Models\SolicitationCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SolicitationCategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $urbanProblems = [
            [
                'name' => 'Ruas com asfalto em mau estado',
                'description' => 'A má qualidade do asfalto nas ruas pode causar danos aos veículos, aumentar o risco de acidentes e dificultar a locomoção.',
            ],
            [
                'name' => 'Falta de rampas de acesso',
                'description' => 'A ausência de rampas de acesso prejudica a mobilidade de pessoas com deficiência ou mobilidade reduzida.',
            ],
            [
                'name' => 'Descarte irregular de lixo',
                'description' => 'O descarte inadequado de lixo provoca poluição ambiental, atrai animais e insetos, além de gerar problemas de saúde pública.',
            ],
            [
                'name' => 'Obras inacabadas',
                'description' => 'Obras não concluídas causam transtornos aos moradores, incluindo ruído, poeira e interrupção do tráfego.',
            ],
        ];

        try {
            DB::beginTransaction();

            foreach ($urbanProblems as $urbanProblemData) {
                SolicitationCategory::create($urbanProblemData);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
