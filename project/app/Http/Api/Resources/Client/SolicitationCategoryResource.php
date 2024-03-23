<?php

namespace App\Http\Api\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitationCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => output_date_format($this->created_at),
            'updated_at' => output_date_format($this->updated_at),
        ];
    }
}
