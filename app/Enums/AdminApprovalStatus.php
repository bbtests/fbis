<?php

namespace App\Enums;

enum AdminApprovalStatus: string {
    case Approved = 'Approved';
    case Banned = 'Banned';
    case Declined = 'Declined';
    case Pending = 'Pending';

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->name, self::cases());
    }
}
