<?php

namespace App\Http\Api\Resources\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'zipCode' => $this->address->zip_code,
            'neighborhood' => $this->address->neighborhood,
            'cityName' => $this->address->city->name,
            'stateName' => $this->address->city->state->name,
            'stateAbbr' => $this->address->city->state->name_abbreviation,
            'created_at' => output_date_format($this->created_at),
            'updated_at' => output_date_format($this->updated_at),
        ];
    }
}
