<?php

namespace App\Documentation\UserSolicitation;

/**
 * @OA\Schema(
 *      title="UserSolicitationResponse",
 *      description="User solicitation response complete information",
 *      type="object",
 *      required={"id", "status", "performedBy", "actionDescription", "createdAt"}
 * )
 */
class UserSolicitationResponse
{
    /**
     * @OA\Property(
     *     type="integer",
     *     title="id",
     *     description="The user solicitation id",
     *     example=1,
     *     readOnly=true
     * )
     */
    public int $id;

    /**
     * @OA\Property(
     *     type="string",
     *     title="status",
     *     description="The user solicitation status when the action was performed",
     *     example="open",
     *     enum={"open", "in_progress", "resolved"},
     *     readOnly=true
     * )
     */
    public string $status;

    /**
     * @OA\Property(
     *     type="string",
     *     title="performedBy",
     *     description="The user name who performed the action, with the first 7 characters visible to protect privacy",
     *     example="New Use*",
     *     readOnly=true
     * )
     */
    public string $performedBy;

    /**
     * @OA\Property(
     *     type="string",
     *     title="actionDescription",
     *     description="The user solicitation action description" ,
     *     example="created",
     *     enum={"created", "updated", "status_updated", "like"},
     *     readOnly=true
     * )
     */
    public string $actionDescription;

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
}
