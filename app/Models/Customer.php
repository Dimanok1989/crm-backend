<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'phone',
        'firstname',
        'lastname',
        'patronymic',
    ];

    /**
     * ФИО клиента
     * 
     * @return string
     * @property string $name
     */
    public function getNameAttribute(): string
    {
        return collect([
            $this->lastname,
            $this->firstname,
            $this->patronymic,
        ])->filter()->join(" ");
    }
}
