<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Filament\Resources\PurchaseResource\RelationManagers\InvoicesRelationManager;
use App\Filament\Resources\PurchaseResource\RelationManagers\ProductsRelationManager;
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
use Filament\Tables\Columns\TextColumn;
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
                                  ->options(function () {
        return \App\Models\Product::query()
            ->pluck('name', 'id'); // shows product name, uses id as value
    })
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

                                    ]) ->createOptionUsing(function (array $data) {
        // Save new product and return its ID
        return \App\Models\Product::create($data)->id;
    }),
                                TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(fn(callable $get, Set $set) => self::updateFormData($get, $set)),

                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(fn(callable $get, Set $set) => self::updateFormData($get, $set)),

                                TextInput::make('total')
                                    ->required()
                                    ->disabled()
                                    ->numeric(),


                                ]),
                                Section::make('Total Details')
                                ->columns(3)
                                ->schema([
                                    TextInput::make("total_amount")
                                    ->label("Sub Total")
                                    ->required()
                                    ->default(0)
                                    ->prefix('$')
                                    ->numeric()
                                    
                                   ,
                                    TextInput::make("discount")
                                    ->label("Discount")
                                    ->required()
                                    ->default(0)
                                    ->prefix('$')
                                    ->numeric()
                                     ->reactive()
                                     ->afterStateUpdated(function(callable $get, Set $set){
                                        $discount = intval($get('discount')) ?? 0;
                                        $total_amount = intval($get('total_amount')) ?? 0;
                                       
                                        $set('net_total', $total_amount - $discount);
                                     }),
                                    TextInput::make("net_total")
                                    ->label("Grand Total")
                                    ->required()
                                    ->disabled(),
                                ])


                    ]),



            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("invoice_no"),
                TextColumn::make("provider.name"),

                TextColumn::make("purchase_date"),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('View Invoice')
                    ->icon('heroicon-s-document-text')
                    ->url(fn ($record) =>self::getUrl("invoice",["record"=>$record->id])),
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
            ProductsRelationManager::class,
            InvoicesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
            "invoice"=>Pages\Invoice::route("{record}/invoice"),
        ];
    }
    public static function updateFormData($get, $set)
    {
        $formData=$get("../../");
        
        $allProducts=$formData['products'] ?? [];
        $grandTotal=0;
        foreach($allProducts as $product){
            $price = intval($product['price']) ?? 0;
            $quantity = intval($product['quantity']) ?? 0;
            $total = $price * $quantity;
            $grandTotal+=$total;

        }
        $price = intval($get('price'));
        $quantity = intval($get('quantity'));
        $total = $price * $quantity;
        $set('total', $total);
        $set('../../total_amount', $grandTotal);
       $discount= $get('../../discount');
        $set('../../net_total', $grandTotal - $discount);
    }
}
