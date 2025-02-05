<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskCollectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'image_url' => $this->resource->image_url,
            'available_count' => $this->resource->count - $this->resource->participants->count(),
            'created_at' => $this->resource->created_at->format('d.m.Y H:i:s'),
            'updated_at' => $this->resource->updated_at->format('d.m.Y H:i:s'),
        ];
    }
}
