<?php

namespace App\Facader;

use App\Http\Services\Fields\FieldService;
use Illuminate\Support\Facades\Facade;

class Fields extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return FieldService::class;
    }
}
