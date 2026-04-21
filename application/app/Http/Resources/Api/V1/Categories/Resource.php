<?php

namespace App\Http\Resources\Api\V1\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->getParentId(),
            'alias' => $this->getAlias(),
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAtFormatted(),
            'updated_at' => $this->getUpdatedAtFormatted(),
        ];
    }
}
