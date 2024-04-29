<?php

namespace App\Http\Api\Resources\Client\Solicitation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'latitudeCoordinates' => $this->latitude_coordinates,
            'longitudeCoordinates' => $this->longitude_coordinates,
            'status' => $this->status,
            'likesCount' => $this->likes_count,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
