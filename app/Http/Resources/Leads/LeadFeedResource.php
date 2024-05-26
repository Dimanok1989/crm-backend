<?php

namespace App\Http\Resources\Leads;

use App\Enums\Leads\LeadStatuses;
use App\Http\Resources\User\UserShortResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadFeedResource extends JsonResource
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
            'createdAt' => $this->created_at,
            'user' => $this->user ? new UserShortResource($this->user) : null,
            'title' => $this->type ? $this->type->message($this->user) : null,
            'status' => LeadStatuses::resource($this->status_id),
            'content' => $this->content,
        ];
    }
}
