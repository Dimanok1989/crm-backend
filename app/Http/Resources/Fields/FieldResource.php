<?php

namespace App\Http\Resources\Fields;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'placeholder' => $this->placeholder,
            'type' => $this->type->value ?? null,
            'typeName' => $this->type?->name() ?? null,
            'isOptions' => $this->type?->isOptions() ?? false,
            'options' => $this->attributes['options'] ?? [],
        ];
    }
}
