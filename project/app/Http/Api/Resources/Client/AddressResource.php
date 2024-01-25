<?php

namespace App\Http\Api\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'zipCode' => $this->zip_code,
            'neighborhood' => $this->neighborhood,
            'cityName' => $this->city->name,
            'stateName' => $this->city->state->name,
            'stateAbbreviation' => $this->city->state->name_abbreviation,
            'created_at' => output_date_format($this->created_at),
            'updated_at' => output_date_format($this->updated_at),
        ];
    }
}
