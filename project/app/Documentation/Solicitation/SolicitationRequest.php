<?php

namespace App\Documentation\Solicitation;

/**
 * @OA\Schema(
 *      title="Solicitation",
 *      description="Solicitation request information",
 *      type="object",
 *      required={"title", "report", "latitudeCoordinate", "longitudeCoordinate", "solicitationCategoryId"}
 * )
 */
class SolicitationRequest
{
    /**
     * @OA\Property(
     *     type="string",
     *     title="title",
     *     description="The title that best describes the solicitation",
     *     example="Rampa de acesso com buracos",
     * )
     */
    public string $title;

    /**
     * @OA\Property(
     *     type="string",
     *     title="report",
     *     description="The report that describes the reason for the solicitation",
     *     example="Na frente da escola municipal, existe uma rampa de acesso com buracos, impossibilitando o seu uso com segurança.",
     * )
     */
    public string $report;

    /**
     * @OA\Property(
     *     type="string",
     *     title="latitudeCoordinate",
     *     description="Latitude coordinate of the solicitation",
     *     example="-25.430",
     * )
     */
    public string $latitudeCoordinate;

    /**
     * @OA\Property(
     *     type="string",
     *     title="longitudeCoordinate",
     *     description="Longitude coordinate of the solicitation",
     *     example="-49.271",
     * )
     */
    public string $longitudeCoordinate;

    /**
     * @OA\Property(
     *     type="integer",
     *     title="solicitationCategoryId",
     *     description="Id of the solicitation category that best describes the solicitation",
     *     example="1",
     *     writeOnly=true
     * )
     */
    public string $solicitationCategoryId;
}
