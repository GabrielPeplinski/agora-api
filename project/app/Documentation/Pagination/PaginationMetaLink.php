<?php

namespace App\Documentation\Pagination;

/**
 * @OA\Schema(
 *     schema="PaginationMetaLink",
 *     type="object",
 *     title="Pagination Meta Link",
 *     description="Meta link for pagination",
 * )
 */
class PaginationMetaLink
{
    /**
     * @OA\Property(
     *     type="string",
     *     nullable=true,
     *     example=null
     * )
     */
    public ?string $url;

    /**
     * @OA\Property(
     *     type="string",
     *     example="&laquo; Anterior"
     * )
     */
    public string $label;

    /**
     * @OA\Property(
     *     type="boolean",
     *     example=false
     * )
     */
    public bool $active;
}
