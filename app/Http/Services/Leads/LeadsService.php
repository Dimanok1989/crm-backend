<?php

namespace App\Http\Services\Leads;

use App\Models\Lead;
use App\Models\User;

class LeadsService
{
    /**
     * Создание новой заявки
     * 
     * @param array $data
     * @return \App\Models\Lead
     */
    public function create(array $data)
    {
        return Lead::create($data)->refresh();
    }

    public function list(User $user)
    {
        return Lead::query()
            ->with('customer')
            ->whereUserId($user->id)
            ->orderByDesc('id')
            ->paginate();
    }
}
