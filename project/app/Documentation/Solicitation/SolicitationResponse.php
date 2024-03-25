<?php

namespace App\Documentation\Solicitation;

/**
 * @OA\Schema(
 *      title="SolicitationResponse",
 *      description="Solicitation response information",
 *      type="object",
 *      required={"id", "title", "status", "report", "latitudeCoordinate", "longitudeCoordinate", "solicitationCategory"}
 * )
 */
class SolicitationResponse
{
    /**
     * @OA\Property(
     *     type="integer",
     *     title="id",
     *     description="Id of the solicitation",
     *     example="1",
     *     readOnly=true
     * )
     */
    public string $id;

    /**
     * @OA\Property(
     *     type="string",
     *     title="title",
     *     description="The title that best describes the solicitation",
     *     example="Rampa de acesso com buracos",
     *     readOnly=true
     * )
     */
    public string $title;

    /**
     * @OA\Property(
     *     type="string",
     *     title="report",
     *     description="The report that describes the reason for the solicitation",
     *     example="Na frente da escola municipal, existe uma rampa de acesso com buracos, impossibilitando o seu uso com segurança.",
     *     readOnly=true
     * )
     */
    public string $report;

    /**
     * @OA\Property(
     *     type="string",
     *     title="status",
     *     description="The status of the solicitation",
     *     example="open",
     *     readOnly=true
     * )
     */
    public string $status;

    /**
     * @OA\Property(
     *     type="string",
     *     title="latitudeCoordinate",
     *     description="Latitude coordinate of the solicitation",
     *     example="-25.430",
     *     readOnly=true
     * )
     */
    public string $latitudeCoordinate;

    /**
     * @OA\Property(
     *     type="string",
     *     title="longitudeCoordinate",
     *     description="Longitude coordinate of the solicitation",
     *     example="-49.271",
     *     readOnly=true
     * )
     */
    public string $longitudeCoordinate;

    /**
     * @OA\Property(
     *     type="string",
     *     title="createdAt",
     *     description="Date of creation",
     *     example="2021-09-01T00:00:00.000000Z",
     *     readOnly=true
     * )
     */
    public string $createdAt;

    /**
     * @OA\Property(
     *     type="string",
     *     title="updatedAt",
     *     description="Date of last update",
     *     example="2021-09-01T00:00:00.000000Z",
     *     readOnly=true
     * )
     */
    public string $updateAt;

    /**
     * @OA\Property(
     *     type="object",
     *     title="solicitationCategory",
     *     description="The solicitation category data that best describes the solicitation",
     *     ref="#/components/schemas/SolicitationCategory",
     *     readOnly=true
     * )
     */
    public string $solicitationCategory;
}
