<?php

namespace App\Http\Api\Resources\Shared\Solicitation;

use App\Http\Api\Resources\Shared\SolicitationImage\SolicitationImageResource;
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
            'coverImage' => '',
//            'coverImageLink' => SolicitationImageResource::make($this->coverImage),
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
