<?php

namespace App\Documentation\Solicitation;

/**
 * @OA\Schema(
 *      title="ShowSolicitationResponse",
 *      description="Solicitation response complete information",
 *      type="object",
 *      required={"title", "description", "latitudeCoordinates", "longitudeCoordinates", "solicitationCategoryId"}
 * )
 */
class SolicitationPayload
{
    /**
     * @OA\Property(
     *     type="string",
     *     title="title",
     *     description="The title that best describes the solicitation",
     *     example="Rampa de acesso com buracos",
     *     readOnly=false
     * )
     */
    public string $title;

    /**
     * @OA\Property(
     *     type="string",
     *     title="description",
     *     description="The description that describes the reason for the solicitation",
     *     example="Na frente da escola municipal, existe uma rampa de acesso com buracos, impossibilitando o seu uso com segurança.",
     *     readOnly=false
     * )
     */
    public string $description;

    /**
     * @OA\Property(
     *     type="string",
     *     title="latitudeCoordinates",
     *     description="Latitude coordinate of the solicitation",
     *     example="-23.5505199",
     *     readOnly=false
     * )
     */
    public string $latitudeCoordinates;

    /**
     * @OA\Property(
     *     type="string",
     *     title="longitudeCoordinates",
     *     description="Longitude coordinate of the solicitation",
     *     example="-46.6333094",
     *     readOnly=false
     * )
     */
    public string $longitudeCoordinates;

    /**
     * @OA\Property(
     *     type="object",
     *     title="solicitationCategoryId",
     *     description="The solicitation category id that best describes the solicitation",
     *     example=1,
     *     readOnly=false
     * )
     */
    public string $solicitationCategoryId;
}
