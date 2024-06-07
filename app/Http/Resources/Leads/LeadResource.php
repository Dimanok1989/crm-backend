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
            'status_id' => $this->status_id,
            'status' => LeadStatuses::resource($this->status_id),
            'name' => $this->name ?: $this->number,
            'number' => $this->number,
            'customer_id' => $this->customer_id,
            'customer' => $this->customer ? new CustomerResource($this->customer) : null,
            'event_start_at' => $this->event_start_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
