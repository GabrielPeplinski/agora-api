<?php

namespace App\Http\Api\Resources\Client\Selects;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitationCategorySelectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}