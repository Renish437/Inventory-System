<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentClusters\Forms\Cluster;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

     protected static ?string $navigationGroup = 'Product Management';

    
    public static function getNavigationLabel(): string
    {
        return __('Products');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
               
             Section::make('Product Details')->schema(
                 self::getProductForm()
                
             )->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              
             
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('safety_stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    public static function getProductForm():array{
        return [
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
                    Cluster::make([
                           
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->placeholder('Price')
                            ->default(0.00)
                            ->prefix('$'),
                             Forms\Components\Select::make('unit_id')
                            ->required()
                            ->relationship('unit', 'key')
                            ->placeholder('Select Unit')
                            ->searchable()
                            ->preload()
                            
                           ,
                         
                           ])->label("Product Price")
                            ->helperText("Eg: kg, g, l"),
                           Forms\Components\Select::make('category_id')
                           ->required()
                           ->relationship('category', 'name')
                           ->searchable()
                           ->preload()
                         ->columnSpan(2)
                          ,
               
              
                Forms\Components\TextInput::make('safety_stock')
                    ->required()
                    ->numeric()
                    ->helperText("Minimum stock to be stored in the warehouse")
                    ->default(0.00),
                Forms\Components\DatePicker::make('expiry_date'),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\KeyValue::make('data')
                ->label("Extra Details")
                    ->columnSpanFull(),
        ];
    }
}
