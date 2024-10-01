<?php

namespace App\Enums;

enum ProductStatus: int
{
    case Pending = 2;
    case Approved = 1;
    case Declined = 3;

    public function description(): string
    {
        return match ($this) {
            self::Pending => 'pending',
            self::Approved => 'approved',
            self::Declined => 'declined',
        };
    }
}
