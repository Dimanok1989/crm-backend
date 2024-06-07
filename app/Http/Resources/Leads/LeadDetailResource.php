<?php

namespace App\Http\Resources\Leads;

use App\Facader\Fields;
use App\Http\Resources\Fields\FieldResource;
use Illuminate\Http\Request;

class LeadDetailResource extends LeadResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $fields = Fields::list($request->user());

        return [
            ...parent::toArray($request),
            'fields' => FieldResource::collection($fields),
            'feeds' => LeadFeedResource::collection(
                $this->feeds()->with('user')->orderByDesc('id')->get()
            ),
        ];
    }
}
