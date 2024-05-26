<?php

namespace App\Enums\Leads;

use App\Models\User;
use Illuminate\Support\Str;

enum LeadFeedTypes: int
{
    case create = 1;
    case update = 2;
    case status = 3;

    /**
     * Системное сообщение события
     * 
     * @param null|\App\Models\User $user
     * @return null|string
     */
    public function message(?User $user)
    {
        return match ($this) {
            static::create => "Создал(а) новую заявку",
            static::update => "Изменил(а) заявку",
            static::status => "Изменил(а) статус",
            default => null,
        };
    }
}
