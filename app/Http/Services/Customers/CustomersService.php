<?php

namespace App\Http\Services\Customers;

use App\Models\Customer;

class CustomersService
{
    /**
     * Создание нового клиента
     * 
     * @param array $data
     * @return \App\Models\Customer
     */
    public function create(array $data)
    {
        return Customer::create($data)->refresh();
    }

    /**
     * Поиск клиентов пользователя
     * 
     * @param string $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(string $search)
    {
        return Customer::query()
            ->where('user_id', auth()->id())
            ->where(function ($query) use ($search) {
                $query->where('lastname', 'like', "%$search%")
                    ->orWhere('firstname', 'like', "%$search%")
                    ->orWhere('patronymic', 'like', "%$search%");
            })
            ->paginate(30);
    }
}