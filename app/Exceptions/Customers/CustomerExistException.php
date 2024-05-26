<?php

namespace App\Exceptions\Customers;

use App\Http\Resources\Customers\CustomerResource;
use App\Models\Customer;
use Exception;

class CustomerExistException extends Exception
{
    /**
     * Init exeption
     * 
     * @param \App\Models\Customer $customer
     * @return void
     */
    public function __construct(protected Customer $customer)
    {
        parent::__construct();
    }

    /**
     * Render the exception into an HTTP response.
     * 
     * @return \App\Http\Resources\Customers\CustomerResource
     */
    public function render()
    {
        return new CustomerResource($this->customer);
    }
}
