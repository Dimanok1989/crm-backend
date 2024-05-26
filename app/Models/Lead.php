<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status_id',
        'customer_id',
        'event_start_at',
        'name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'event_start_at' => 'datetime',
        ];
    }

    /**
     * Клиент, принадлежащий заявке
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * События, принадлежащие заявке
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds()
    {
        return $this->hasMany(LeadFeed::class);
    }

    /**
     * Номер заявки
     * 
     * @return string
     */
    public function getNumberAttribute()
    {
        return "A-" . Str::padLeft((string) $this->id, 6, "0");
    }
}
