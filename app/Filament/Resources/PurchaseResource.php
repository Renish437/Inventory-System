<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\Purchase;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationGroup = 'Transactions';
    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function getNavigationLabel(): string
    {
        return __('Purchases');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Purchase Details')
                    ->heading('Provider Details')
                    ->columns(3)
                    ->schema([

                        Select::make('provider_id')
                            ->required()
                            ->relationship('provider', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm(
                                function () {

                                    $tenant_id = [
                                        Forms\Components\Hidden::make('tenant_id')
                                            ->default(Filament::getTenant()->id),
                                    ];

                                    return array_merge($tenant_id, ProviderResource::getProviderFormSchema());
                                }


                            ),
                        TextInput::make('invoice_no')
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('purchase_date'),
                    ]),
                Section::make('Product Details')
                    ->columns(1)
                    ->schema([
                        Repeater::make('products')
                            ->columns(4)
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->required()
                                    ->relationship('products', 'name')

                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        Forms\Components\Hidden::make('tenant_id')
                                            ->default(Filament::getTenant()->id),
                                        Forms\Components\TextInput::make('name')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('code')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\TextInput::make('quantity')
                                            ->required()
                                            ->numeric()
                                            ->default(1.00),
                                        Forms\Components\TextInput::make('price')
                                            ->required()
                                            ->numeric()
                                            ->default(0.00)
                                            ->prefix('$'),
                                        Forms\Components\Select::make('category_id')
                                            ->required()
                                            ->options(function () {
                                                return \App\Models\Category::all()->pluck('name', 'id');
                                            })
                                            ->searchable()
                                            ->preload(),
                                        Forms\Components\Select::make('unit_id')
                                            ->required()
                                            ->options(function () {
                                                return \App\Models\Unit::all()->pluck('key', 'id');
                                            })
                                            ->searchable()
                                            ->preload(),

                                        Forms\Components\TextInput::make('safety_stock')
                                            ->required()
                                            ->numeric()
                                            ->helperText("Minimum stock to be stored in the warehouse")
                                            ->default(0.00),
                                        Forms\Components\DatePicker::make('expiry_date'),

                                    ]),
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $get, Set $set) {
                                        $price = $get('price');
                                        $quantity = $get('quantity');
                                        $total = $price * $quantity;
                                        $set('total', $total);
                                    }),
                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(function (callable $get, Set $set) {
                                        $price = $get('price');
                                        $quantity = $get('quantity');
                                        $total = $price * $quantity;
                                        $set('total', $total);
                                    }),

                                TextInput::make('total')
                                    ->required()
                                    ->numeric(),


                            ])


                    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }
}
