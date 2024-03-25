<?php

namespace App\Documentation;

/**
 * @OA\Schema(
 *      title="Solicitation",
 *      description="Solicitation information",
 *      type="object",
 *      required={"id", "status", "report", "latitudeCoordinate", "longitudeCoordinate", "solicitationCategoryId"}
 * )
 */
class Solicitation
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Id of the solicitation",
     *     example="1",
     *     readOnly=true
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
     *     title="solicitationCategoryId",
     *     description="Id of the solicitation category that best describes the solicitation",
     *     example="1",
     *     writeOnly=true
     * )
     */
    public string $solicitationCategoryId;

    /**
     * @OA\Property(
     *     title="createdAt",
     *     description="Date of creation",
     *     example="2021-09-01T00:00:00.000000Z",
     *     readOnly=true
     * )
     */
    public string $createdAt;

    /**
     * @OA\Property(
     *     title="updatedAt",
     *     description="Date of last update",
     *     example="2021-09-01T00:00:00.000000Z",
     *     readOnly=true
     * )
     */
    public string $updateAt;
}
