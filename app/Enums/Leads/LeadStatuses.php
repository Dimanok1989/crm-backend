<?php

namespace App\Enums\Leads;

use Illuminate\Support\Str;

enum LeadStatuses: int
{
    case new = 1;
    case in_work = 2;
    case canseled = 3;
    case missed_call = 4;
    case ponders = 5;
    case paid = 6;
    case completed = 7;

    public function name()
    {
        return match ($this) {
            static::new => "Новая заявка",
            static::in_work => "В работе",
            static::canseled => "Отменено",
            static::missed_call => "Недозвон",
            static::ponders => "Под вопросом",
            static::paid => "Оплачено",
            static::completed => "Завершено",
            default => Str::headline($this->name),
        };
    }

    public function color()
    {
        return match ($this) {
            static::new => "rgb(203 213 225)",
            static::in_work => "rgb(59 130 246)",
            static::canseled => "rgb(244 63 94)",
            static::missed_call => "rgb(253 224 71)",
            static::ponders => "rgb(120 53 15)",
            static::paid => "rgb(163 230 53)",
            static::completed => "rgb(22 163 74)",
            default => null,
        };
    }

    public static function resource(?int $status)
    {
        if (!$case = static::tryFrom($status)) {
            return null;
        }

        return [
            'id' => $case->value,
            'name' => $case->name(),
            'color' => $case->color(),
        ];
    }
}
