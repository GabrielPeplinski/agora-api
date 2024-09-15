<?php

namespace App\Http\Shared\Controllers\Selects;

use App\Domains\Solicitation\Models\SolicitationCategory;
use App\Http\Shared\Resources\Selects\SolicitationCategorySelectResource;

class SolicitationCategoriesSelectController
{
    /**
     * @OA\Get(
     *     path="/api/selects/solicitation-categories",
     *     operationId="Get Solicitation Categories List",
     *     tags={"Selects"},
     *     summary="Get Solicitation Categories List",
     *     description="Get solicitation categories list",
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved solicitation categories data",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example="1"),
     *                 @OA\Property(property="name", type="string", example="Ruas com asfalto em mau estado"),
     *                 @OA\Property(property="description", type="string", example="A má qualidade do asfalto nas ruas pode causar danos aos veículos, aumentar o risco de acidentes e dificultar a locomoção.")
     *             ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function __invoke()
    {
        $solicitationCategories = app(SolicitationCategory::class)
            ->select('id', 'name', 'description')
            ->get();

        return SolicitationCategorySelectResource::collection($solicitationCategories);
    }
}
