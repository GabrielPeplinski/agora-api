<?php

namespace App\Http\Api\Resources\Shared\Solicitation;

use App\Domains\Solicitation\Enums\SolicitationActionDescriptionEnum;
use App\Http\Shared\Resources\Selects\SolicitationCategorySelectResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowSolicitationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'latitudeCoordinates' => $this->latitude_coordinates,
            'longitudeCoordinates' => $this->longitude_coordinates,
            'status' => $this->current_status,
            'likesCount' => $this->likes_count,
            'coverImage' => $this->getFirstMedia('coverImage')?->getFullUrl(),
            'images' => $this->getMedia('images')
                ->map(function ($media) {
                    return $media->getFullUrl();
                }),
            'solicitationCategory' => SolicitationCategorySelectResource::make($this->whenLoaded('category')),
            'historic' => $this->getSolicitationHistoric(),
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }

    private function getSolicitationHistoric(): array
    {
        return $this->userSolicitations()
            ->where('action_description', '!=', SolicitationActionDescriptionEnum::LIKE)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($historic) {
                return UserSolicitationResource::make($historic);
            })
            ->toArray() ?? [];
    }
}
