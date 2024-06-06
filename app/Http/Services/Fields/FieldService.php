<?php

namespace App\Http\Services\Fields;

use App\Models\Field;
use App\Models\User;

class FieldService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function list(User $user, string $fieldable = "leads")
    {
        return Field::query()
            ->where('user_id', $user->id)
            ->where('fieldable', $fieldable)
            ->get();
    }

    public function create(array $data)
    {
        return Field::create($data)->refresh();
    }

    public function update(Field $field, array $data)
    {
        $field->update($data);

        return $field->refresh();
    }
}
