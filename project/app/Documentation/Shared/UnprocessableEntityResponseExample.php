<?php

namespace App\Documentation\Shared;

/**
 * @OA\Schema(
 *      title="UnprocessableEntityResponseExample",
 *      description="Common 422 Unprocessable Entity response example",
 *      type="object",
 *      required={"message", "errors"}
 * )
 */
class UnprocessableEntityResponseExample
{
    /**
     * @OA\Property(
     *     type="string",
     *     title="message",
     *     description="Validation error message",
     *     example="Validation error example",
     *     readOnly=true
     * )
     */
    public string $message;

    /**
     * @OA\Property(
     *     type="object",
     *     title="errors",
     *     description="Detailed error messages for each invalid field",
     *
     *     @OA\AdditionalProperties(
     *         type="array",
     *
     *         @OA\Items(type="string")
     *     )
     * )
     */
    public array $errors;
}
