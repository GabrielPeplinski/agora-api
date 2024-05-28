<?php

namespace App\Documentation\Pagination;

/**
 * @OA\Schema(
 *     schema="PaginationLinks",
 *     type="object",
 *     title="Pagination Links",
 *     description="Links for pagination",
 * )
 */
class PaginationLinks
{
    /**
     * @OA\Property(
     *     type="string",
     *     title="First page link",
     *     example="http://localhost:8080/api/example?page=1"
     * )
     */
    public string $first;

    /**
     * @OA\Property(
     *     type="string",
     *     title="Last page link",
     *     example="http://localhost:8080/api/example?page=1"
     * )
     */
    public string $last;

    /**
     * @OA\Property(
     *     type="string",
     *     title="Previous page link",
     *     nullable=true,
     *     example=null
     * )
     */
    public ?string $prev;

    /**
     * @OA\Property(
     *     type="string",
     *     title="Next page link",
     *     nullable=true,
     *     example=null
     * )
     */
    public ?string $next;
}
