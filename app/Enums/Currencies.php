<?php

namespace App\Enums;

enum Currencies: string {
    case NGN = 'NGN';
    case USD = 'USD';

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->name, self::cases());
    }
}
