<?php

namespace App\Enums;

enum ResponseStatus: int
{
    case Error = 0;
    case Success = 1;

    public function description(): string
    {
        return match ($this) {
            self::Error => 'Error',
            self::Success => 'Success',
        };
    }
}
