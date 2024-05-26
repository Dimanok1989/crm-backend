<?php

namespace App\Http\Requests\Customers;

use App\Exceptions\Customers\CustomerExistException;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => [
                "required",
                "phone:RU",
                Rule::unique(Customer::class, 'phone')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
            'firstname' => ["required", "string", "max:150"],
            'lastname' => ["nullable", "string", "max:150"],
            'patronymic' => ["nullable", "string", "max:150"],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->phone) {
            $this->merge([
                'phone' => (new PhoneNumber($this->phone, 'RU'))->formatE164(),
            ]);
        }

        $customer = $this->user()->customers()->where('phone', $this->phone)->first();

        if ($customer) {
            throw new CustomerExistException($customer);
        }
    }
}
