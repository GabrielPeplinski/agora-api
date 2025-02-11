<?php

namespace App\Documentation\SolicitationCategory;

/**
 * @OA\Schema(
 *      title="SolicitationCategory",
 *      description="Solicitation category information",
 *      type="object",
 *      required={"id", "name", "description"}
 * )
 */
class SolicitationCategoryResponse
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Id of the solicitation category",
     *     example="1",
     *     readOnly=true
     * )
     */
    public string $id;

    /**
     * @OA\Property(
     *     title="name",
     *     description="The name of the solicitation category",
     *     example="Problemas de Acessibilidade",
     *     readOnly=true
     * )
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="description",
     *     description="The description of the solicitation category",
     *     example="Compreende todos os problemas que envolvem a acessibilidade de pessoas com deficiência como rampas de acesso ou em calçadas, falta de piso tátil direcional, entre outros.",
     *     readOnly=true
     * )
     */
    public string $description;
}
