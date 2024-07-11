<?php

namespace App\Http\Api\Resources\Shared\SolicitationImage;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SolicitationImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'filePath' => $this->file_path,
            'fileName' => $this->file_name,
            'isCoverImage' => $this->is_cover_image,
            'createdAt' => output_date_format($this->created_at),
            'updatedAt' => output_date_format($this->updated_at),
        ];
    }
}
