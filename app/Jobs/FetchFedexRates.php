<?php

namespace App\Jobs;

use App\Models\Product;
use App\Services\Fedex;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchFedexRates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Product $product)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $rates = Fedex::getFreightRates($this->product);

        $this->product->updateQuietly([
            'freight_rates' => $rates->output->rateReplyDetails,
        ]);
    }
}
