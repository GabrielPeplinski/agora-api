<?php

namespace App\Documentation\Solicitation;

/**
 * @OA\Schema(
 *      title="SolicitationResponse",
 *      description="Solicitation response with basic information",
 *      type="object",
 *      required={"id", "title", "likesCount", "createdAt", "updatedAt"}
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
