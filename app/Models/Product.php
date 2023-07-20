<?php

namespace App\Models;

use App\Jobs\FetchFedexRates;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'freight_data' => AsCollection::class,
        'freight_rates' => AsCollection::class,
    ];

    protected static function booted()
    {
        parent::booted();

        static::saved(fn (Product $product) => FetchFedexRates::dispatch($product));
    }
}
