<?php

namespace App\Enums\Concerns;

use BackedEnum;

trait Options
{
    public static function options(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof BackedEnum
            ? array_column($cases, 'name', 'value')
            : array_column($cases, 'name');
    }
}
