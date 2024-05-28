<?php

namespace App\Documentation\Pagination;

/**
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     type="object",
 *     title="Pagination Meta",
 *     description="Metadata for pagination",
 * )
 */
class PaginationMeta
{
    /**
     * @OA\Property(
     *     type="integer",
     *     example=1
     * )
     */
    public int $current_page;

    /**
     * @OA\Property(
     *     type="integer",
     *     nullable=true,
     *     example=null
     * )
     */
    public ?int $from;

    /**
     * @OA\Property(
     *     type="integer",
     *     example=1
     * )
     */
    public int $last_page;

    /**
     * @OA\Property(
     *     type="array",
     *
     *     @OA\Items(ref="#/components/schemas/PaginationMetaLink")
     * )
     */
    public array $links;

    /**
     * @OA\Property(
     *     type="string",
     *     example="http://localhost:8080/api/example"
     * )
     */
    public string $path;

    /**
     * @OA\Property(
     *     type="integer",
     *     example=20
     * )
     */
    public int $per_page;

    /**
     * @OA\Property(
     *     type="integer",
     *     nullable=true,
     *     example=null
     * )
     */
    public ?int $to;

    /**
     * @OA\Property(
     *     type="integer",
     *     example=0
     * )
     */
    public int $total;
}
