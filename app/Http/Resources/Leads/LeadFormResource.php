<?php

namespace App\Http\Resources\Leads;

use App\Enums\Leads\LeadStatuses;
use App\Facader\Fields;
use App\Http\Resources\Customers\CustomerResource;
use App\Http\Resources\Fields\FieldResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'statuses' => collect(LeadStatuses::cases())
                ->map(fn ($case) => [
                    'id' => $case->value,
                    'name' => $case->name(),
                    'color' => $case->color(),
                ]),
            'customers' => CustomerResource::collection(
                $this->customers()->orderByDesc('id')->limit(20)->get(),
            ),
            'fields' => FieldResource::collection(
                Fields::list($request->user())
            )
        ];
    }
}
