<?php

namespace App\Http\Api\Resources\Shared\Solicitation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSolicitationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $this->loadMissing('user');

        return [
            'id' => $this->id,
            'performedBy' => $this->censorName($this->user->name),
            'status' => $this->status,
            'actionDescription' => $this->action_description,
            'image' => $this->getFirstMediaUrl('image'),
            'createdAt' => output_date_format($this->created_at),
        ];
    }

    private function censorName(string $name): string
    {
        return substr($name, 0, 7).str_repeat('*', max(0, strlen($name) - 7));
    }
}
