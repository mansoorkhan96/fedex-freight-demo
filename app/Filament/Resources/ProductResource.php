<?php

namespace App\Filament\Resources;

use App\Enums\FreightClass;
use App\Enums\SubPackagingType;
use App\Enums\Unit;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\ProductResource\Pages;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('sku')->required(),

                TextInput::make('name')->required(),

                TextInput::make('price')->numeric()->required(),

                FileUpload::make('product_image')->image(),

                TextInput::make('upc')->label('Universal Product Code'),

                TextInput::make('uom')->label('Product Unit Of Measure'),

                Section::make('Freight Data')
                    ->columnSpanFull()
                    ->schema([
                        static::freightAddressField('origin'),

                        static::freightAddressField('destination'),

                        // We can enable multiple lineitems in future :)
                        Repeater::make('freight_data.lineItems')
                            ->schema([
                                Hidden::make('id')->default(str()->random()),
                                Select::make('freightClass')->options(FreightClass::options())->default('CLASS_050')->required(),
                                TextInput::make('handlingUnits')->numeric()->default(1)->required(),
                                TextInput::make('pieces')->numeric()->default(1)->required(),
                                Radio::make('subPackagingType')->options(SubPackagingType::options())->default('BUNDLE')->required(),

                                Fieldset::make('Weight')
                                    ->schema([
                                        TextInput::make('weight.value')->numeric()->required(),
                                        Radio::make('weight.units')->options(Unit::options())->default('KG')->required(),
                                    ]),

                                Fieldset::make('Dimensions')
                                    ->columns(4)
                                    ->schema([
                                        TextInput::make('dimensions.length')->numeric(),
                                        TextInput::make('dimensions.width')->numeric(),
                                        TextInput::make('dimensions.height')->numeric(),
                                        Radio::make('dimensions.units')->options(Unit::options()),
                                    ]),
                            ])
                            ->collapsible()
                            ->columnSpanFull()
                            ->minItems(1)
                            ->maxItems(1)
                            ->disableItemCreation()
                            ->disableItemDeletion()
                            ->disableItemMovement()
                            ->columns(4),
                    ]),
            ]);
    }

    protected static function freightAddressField(string $label)
    {
        return Fieldset::make(ucfirst($label))
            ->columns(3)
            ->schema([
                TextInput::make("freight_data.{$label}.streetLines.0")->label('Street Line')->columnSpan(2)->required(),
                TextInput::make("freight_data.{$label}.city")->required(),
                TextInput::make("freight_data.{$label}.stateOrProvinceCode")->required(),
                TextInput::make("freight_data.{$label}.postalCode")->numeric()->required(),
                TextInput::make("freight_data.{$label}.countryCode")->default('US')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('product_image')->square(),
                TextColumn::make('sku')->searchable(),
                TextColumn::make('name')->limit(30)->searchable(),
                TextColumn::make('price')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
