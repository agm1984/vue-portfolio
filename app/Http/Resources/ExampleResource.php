<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExampleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'summary'    => $this->summary,
            'conclusion' => $this->conclusion,
            'status'     => $this->status,
            'category'   => $this->whenLoaded('category'),
            'images'     => $this->whenLoaded('images'),
            'links'      => $this->whenLoaded('links'),
            // << transform tags to array of names >>
            'tags'       => $this->whenLoaded('tags', fn () => $this->tags->pluck('name')->values()),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
