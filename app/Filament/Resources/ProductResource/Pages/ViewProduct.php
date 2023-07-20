<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Illuminate\View\View;
use App\Jobs\FetchFedexRates;
use Filament\Facades\Filament;
use Filament\Pages\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ProductResource;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getActions(): array
    {
        return [
            ...parent::getActions(),
            Action::make('fetch_freight_rates')
                ->action(function () {
                    FetchFedexRates::dispatch($this->record);

                    Notification::make()->success()->body('New rates fetched!');

                    return;
                }),
        ];
    }

    public function render(): View
    {
        Filament::registerRenderHook(
            'page.footer-widgets.start',
            fn () => view('filament.product-freight-rates', [
                'freightRates' => $this->record->freight_rates ?? [],
            ])
        );

        return parent::render();
    }
}
