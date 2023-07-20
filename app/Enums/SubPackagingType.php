<?php

namespace App\Enums;

use App\Enums\Concerns\Options;

enum SubPackagingType: string
{
    use Options;

    case BUNDLE = 'BUNDLE';
    case BAG = 'BAG';
}
