<?php

namespace App\Enums\Fields;

use Illuminate\Support\Str;

enum FieldType: int
{
    case input = 1;
    case number = 2;
    case select = 3;
    case select_multiple = 4;

    public function name()
    {
        return match ($this) {
            static::input => "Строка",
            static::number => "Число",
            static::select => "Выпадающий список",
            static::select_multiple => "Множественный список",
            default => Str::headline($this->name),
        };
    }

    public function isOptions()
    {
        return in_array($this, [
            static::select,
            static::select_multiple,
        ]);
    }

    /**
     * Формирует строку значений перечисленных через запятую
     * для которых обязательно заполнение опций
     * 
     * @return string
     */
    public static function valuesIsOptions()
    {
        foreach (static::cases() as $case) {
            $values[] = $case->isOptions() ? $case->value : null;      
        }

        return collect($values ?? [])->filter()->join(",");
    }

    public function toArray()
    {
        return [
            'id' => $this->value,
            'key' => $this->name,
            'name' => $this->name(),
            'isOptions' => $this->isOptions(),
        ];
    }
}
