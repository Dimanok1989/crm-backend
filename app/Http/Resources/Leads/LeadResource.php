<?php

namespace App\Http\Resources\Leads;

use App\Enums\Leads\LeadStatuses;
use App\Http\Resources\Customers\CustomerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Lead $resource
 */
class LeadResource extends JsonResource
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
            'status' => LeadStatuses::resource($this->status_id),
            'name' => $this->name ?: $this->number,
            'number' => $this->number,
            'customer' => $this->customer ? new CustomerResource($this->customer) : null,
            'eventAt' => $this->event_start_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
