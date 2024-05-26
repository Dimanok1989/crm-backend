<?php

namespace App\Http\Resources\Leads;

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
        return [
            ...parent::toArray($request),
            'feeds' => LeadFeedResource::collection(
                $this->feeds()->with('user')->orderByDesc('id')->get()
            ),
        ];
    }
}
