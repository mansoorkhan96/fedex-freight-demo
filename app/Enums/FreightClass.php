<?php

namespace App\Enums;

use App\Enums\Concerns\Options;

enum FreightClass: string
{
    use Options;

    case CLASS_050 = 'CLASS_050';
    case CLASS_055 = 'CLASS_055';
    case CLASS_060 = 'CLASS_060';
    case CLASS_065 = 'CLASS_065';
}
