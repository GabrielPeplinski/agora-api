<?php

namespace App\Http\Api\Resources\Shared\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'likesCount' => $this->likes_count,
            'coverImage' => $this->getFirstMediaUrl('coverImage'),
            'hasCurrentUserLike' => $this->checkCurrentUserLike(),
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }

    private function checkCurrentUserLike(): bool
    {
        if (current_user()) {
            return current_user()
                ->userSolicitations()
                ->where('action_description', SolicitationActionDescriptionEnum::LIKE)
                ->where('solicitation_id', $this->id)
                ->exists();
        }

        return false;
    }
}
