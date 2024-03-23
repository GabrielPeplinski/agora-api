<?php

namespace App\Http\Api\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'report' => $this->report,
            'status' => $this->status,
            'latitudeCoordinate' => $this->latitude_coordinate,
            'longitudeCoordinate' => $this->longitude_coordinate,
            'solicitationCategory' => SolicitationCategoryResource::make($this->whenLoaded('solicitationCategory')),
            'created_at' => output_date_format($this->created_at),
            'updated_at' => output_date_format($this->updated_at),
        ];
    }
}
