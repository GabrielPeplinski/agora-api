<?php

namespace App\Documentation\Solicitation;

use App\Documentation\Pagination\PaginationLinks;
use App\Documentation\Pagination\PaginationMeta;

/**
 * @OA\Schema(
 *      schema="SolicitationPaginatedResponse",
 *      type="object",
 *      title="Solicitation Paginated Response",
 *      description="Paginated response structure for solicitations",
 * )
 */
class SolicitationPaginatedResponse
{
    /**
     * @OA\Property(
     *     type="array",
     *
     *     @OA\Items(ref="#/components/schemas/SolicitationResponse")
     * )
     */
    public array $data;

    /**
     * @OA\Property(
     *     ref="#/components/schemas/PaginationLinks"
     * )
     */
    public PaginationLinks $links;

    /**
     * @OA\Property(
     *     ref="#/components/schemas/PaginationMeta"
     * )
     */
    public PaginationMeta $meta;
}
