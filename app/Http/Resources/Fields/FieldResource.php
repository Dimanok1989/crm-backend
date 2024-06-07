<?php

namespace App\Http\Resources\Fields;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property null|string $placeholder
 * @property \App\Enums\Fields\FieldType $type
 */
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
            'typeKey' => $this->type->name ?? null,
            'typeName' => $this->type?->name() ?? null,
            'isOptions' => $this->type?->isOptions() ?? false,
            'options' => $this->attributes['options'] ?? [],
        ];
    }
}
