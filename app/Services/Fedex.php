<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Fedex
{
    public static function getAccessToken(): ?string
    {
        if (Cache::has('fedex_access_token')) {
            return Cache::get('fedex_access_token');
        }

        try {
            $response = Http::baseUrl(config('services.fedex.base_url'))
                ->asForm()
                ->post('/oauth/token', [
                    'grant_type' => 'client_credentials',
                    'client_id' => config('services.fedex.api_key'),
                    'client_secret' => config('services.fedex.api_secret'),
                ])
                ->object();
        } catch (\Throwable $th) {
            info('Could not get fedex access token. Error: ' . $th->getMessage());
        }

        if (filled($response?->access_token)) {
            Cache::put('fedex_access_token', $response?->access_token, now()->addMinutes(55));
        }

        return $response?->access_token;
    }

    public static function getFreightRates(Product $product): object | false
    {
        try {
            return Http::baseUrl(config('services.fedex.base_url'))
                ->withToken(static::getAccessToken())
                ->asJson()
                ->post('/rate/v1/freight/rates/quotes', static::createPayload($product))
                ->object();
        } catch (\Throwable $th) {
            info('Could not get fedex rates. Error: ' . $th->getMessage());
        }

        return false;
    }

    protected static function createPayload(Product $product): array
    {
        $accountNumber = config('services.fedex.account_number');
        $origin = $product->freight_data['origin'];
        $destination = $product->freight_data['destination'];
        $lineItems = $product->freight_data['lineItems'];

        return [
            'rateRequestControlParameters' => ['returnTransitTimes' => true],
            'accountNumber' => ['value' => $accountNumber],
            'freightRequestedShipment' => [
                'serviceType' => 'FEDEX_FREIGHT_PRIORITY',
                'shipper' => ['address' => Arr::except($origin, 'streetLines')],
                'recipient' => ['address' => Arr::except($destination, 'streetLines')],
                'shippingChargesPayment' => [
                    'paymentType' => 'SENDER',
                    'payor' => [
                        'responsibleParty' => [
                            'accountNumber' => ['value' => $accountNumber],
                        ],
                    ],
                ],
                'freightShipmentDetail' => [
                    'role' => 'SHIPPER',
                    'accountNumber' => ['value' => $accountNumber],
                    'fedExFreightBillingContactAndAddress' => [
                        'address' => $origin,
                    ],
                    'lineItem' => $lineItems,
                ],
                'rateRequestType' => ['LIST'],
                'requestedPackageLineItems' => array_map(function ($lineItem) {
                    $mappedLineItem = [
                        'associatedFreightLineItems' => [['id' => $lineItem['id']]],
                        'weight' => $lineItem['weight'],
                        'subPackagingType' => $lineItem['subPackagingType'],
                    ];

                    if (Arr::has($lineItem, 'dimensions')) {
                        $mappedLineItem['dimensions'] = $lineItem['dimensions'];
                    }

                    return $mappedLineItem;
                }, $lineItems),
            ],
        ];
    }
}
