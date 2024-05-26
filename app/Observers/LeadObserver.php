<?php

namespace App\Observers;

use App\Enums\Leads\LeadFeedTypes;
use App\Models\Lead;

class LeadObserver
{
    /**
     * Handle the Lead "created" event.
     */
    public function created(Lead $lead): void
    {
        $lead->feeds()->create([
            'user_id' => auth()->id(),
            'status_id' => $lead->status_id,
            'type' => LeadFeedTypes::create,
        ]);
    }

    /**
     * Handle the Lead "updated" event.
     */
    public function updated(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "deleted" event.
     */
    public function deleted(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "restored" event.
     */
    public function restored(Lead $lead): void
    {
        //
    }

    /**
     * Handle the Lead "force deleted" event.
     */
    public function forceDeleted(Lead $lead): void
    {
        //
    }
}
