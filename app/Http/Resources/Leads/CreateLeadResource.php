<?php

namespace App\Http\Resources\Leads;

use App\Enums\Leads\LeadStatuses;
use App\Http\Resources\Customers\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateLeadResource extends JsonResource
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
        ];
    }
}
