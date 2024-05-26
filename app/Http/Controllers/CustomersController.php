<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customers\CustomerRequest;
use App\Http\Resources\Customers\CustomerResource;
use App\Http\Services\Customers\CustomersService;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Создание нового клиента
     * 
     * @param \App\Http\Requests\Customers\CustomerRequest $request
     * @param \App\Http\Services\Customers\CustomersService $service
     * @return \App\Http\Resources\Customers\CustomerResource
     */
    public function store(CustomerRequest $request, CustomersService $service)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id ?? null;

        return new CustomerResource(
            $service->create($data)
        );
    }

    /**
     * Поиск клиентов
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Http\Services\Customers\CustomersService $service
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $request, CustomersService $service)
    {
        return CustomerResource::collection(
            $service->search((string) $request->get('query'))
        );
    }
}
