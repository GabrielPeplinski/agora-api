<?php

namespace App\Documentation\Shared;

/**
 * @OA\Schema(
 *      title="ForbiddenResponseExample",
 *      description="Common 403 Forbidden response example",
 *      type="object",
 *      required={"message"}
 * )
 */
class ForbiddenResponseExample
{
    /**
     * @OA\Property(
     *     type="string",
     *     title="message",
     *     description="Forbidden error message example",
     *     example="This route is forbidden for current user role.",
     *     readOnly=true
     * )
     */
    public string $message;
}
