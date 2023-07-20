<div>
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-base font-semibold leading-6 text-gray-900">Fedex Freight Rates</h1>
    </div>
  </div>
  <div class="mt-8 flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
        <table class="min-w-full divide-y divide-gray-300">
          <thead>
            <tr>
              <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Arrives On</th>
              <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Delivered By</th>
              <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Base rate</th>
              <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Fuel Surcharge</th>
              <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Estimated Total</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            @forelse ($freightRates as $rate)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                        {{ now()->parse(Arr::get($rate, 'operationalDetail.deliveryDate'))->format('F, j Y') }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Fedex</td>
                    <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-gray-500">
                        $ {{ Arr::get($rate, 'ratedShipmentDetails.0.totalBaseCharge') }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-gray-500">
                        $ {{ Arr::get($rate, 'ratedShipmentDetails.0.shipmentRateDetail.totalSurcharges') }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-gray-500">
                        $ {{ Arr::get($rate, 'ratedShipmentDetails.0.totalNetCharge') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0" colspan="5">No rates available. Please try to Fetch/Refresh Rates..</td>
                </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
