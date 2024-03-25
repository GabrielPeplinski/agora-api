<?php

namespace App\Documentation\Responses;

/**
 * @OA\Schema(
 *      title="SolicitationResponse",
 *      description="Solicitation information",
 *      type="object",
 *     required={"id", "status", "latitudeCoordinate", "longitudeCoordinate", "solicitationCategory", "createdAt", "updatedAt"}
 * )
 */

class SolicitationResponse
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Id of the solicitation",
     *     example="1",
     * )
     */
    public string $id;

    /**
     * @OA\Property(
     *     title="title",
     *     description="The title that best describes the solicitation",
     *     example="Centro",
     * )
     */
    public string $title;

    /**
     * @OA\Property(
     *     title="report",
     *     description="The report that describes the reason for the solicitation",
     *     example="Guarapuava",
     * )
     */
    public string $report;

    /**
     * @OA\Property(
     *     title="status",
     *     description="The status of the solicitation",
     *     example="PR",
     * )
     */
    public string $status;

    /**
     * @OA\Property(
     *     title="latitudeCoordinate",
     *     description="Latitude coordinate of the solicitation",
     *     example="-25.430",
     * )
     */
    public string $latitudeCoordinate;

    /**
     * @OA\Property(
     *     title="longitudeCoordinate",
     *     description="Longitude coordinate of the solicitation",
     *     example="-49.271",
     * )
     */
    public string $longitudeCoordinate;

    /**
     * @OA\Property(
     *     title="solicitationCategory",
     *     description="Id of the solicitation category that best describes the solicitation",
     *     example="1",
     * )
     */
    public string $solicitationCategory;

    /**
     * @OA\Property(
     *     title="createdAt",
     *     description="Date of creation",
     *     example="2021-09-01T00:00:00.000000Z",
     * )
     */
    public string $createdAt;

    /**
     * @OA\Property(
     *     title="updatedAt",
     *     description="Date of last update",
     *     example="2021-09-01T00:00:00.000000Z",
     * )
     */
    public string $updateAt;
}
