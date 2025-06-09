<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
       protected static ?string $navigationGroup = 'Entities';

    // public static function getNavigationGroup(): ?string
    // {
    //     return 'Customers';
    // }
    public static function getNavigationLabel(): string
    {
        return __('Customers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('tenant_id')
                //     ->required()
                //     ->numeric(),
               Section::make('Customer Details'
               )->schema([
                    Forms\Components\TextInput::make('name')

                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('contact')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->maxLength(255)
                    ->default(null),
                // Forms\Components\Textarea::make('data')
                //     ->columnSpanFull(),
                Forms\Components\KeyValue::make('data')
                ->label("Extra Details")
                    ->columnSpanFull(),
               ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('tenant_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('name')
                ->label("Customer Name")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label("Customer Email")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact')
                  ->label("Customer Contact")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label("Customer Address")
                    ->searchable(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
