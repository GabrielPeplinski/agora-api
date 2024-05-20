<?php

namespace App\Documentation\Solicitation;

/**
 * @OA\Schema(
 *      title="SolicitationResponse",
 *      description="Solicitation response information",
 *      type="object",
 *      required={"id", "title", "description", "status", "latitudeCoordinates", "longitudeCoordinates", "likesCount", "solicitationCategory", "createdAt", "updatedAt", "updatedAt"}
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
     *     title="description",
     *     description="The description that describes the reason for the solicitation",
     *     example="Na frente da escola municipal, existe uma rampa de acesso com buracos, impossibilitando o seu uso com segurança.",
     *     readOnly=true
     * )
     */
    public string $description;

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
     *     title="latitudeCoordinates",
     *     description="Latitude coordinate of the solicitation",
     *     example="-25.430",
     *     readOnly=true
     * )
     */
    public string $latitudeCoordinates;

    /**
     * @OA\Property(
     *     type="string",
     *     title="longitudeCoordinates",
     *     description="Longitude coordinate of the solicitation",
     *     example="-49.271",
     *     readOnly=true
     * )
     */
    public string $longitudeCoordinates;

    /**
     * @OA\Property(
     *     type="integer",
     *     title="likesCount",
     *     description="The total os likes the solicitation has received",
     *     example=100,
     *     readOnly=true
     * )
     */
    public string $likesCount;

    /**
     * @OA\Property(
     *     type="object",
     *     title="solicitationCategory",
     *     description="The solicitation category data that best describes the solicitation",
     *     ref="#/components/schemas/SolicitationCategoryResponse",
     *     readOnly=true
     * )
     */
    public string $solicitationCategory;

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
}
