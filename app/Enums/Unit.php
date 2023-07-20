<?php

namespace App\Enums;

use App\Enums\Concerns\Options;

enum Unit: string
{
    use Options;

    case KG = 'KG';
    case LB = 'LB';
}
