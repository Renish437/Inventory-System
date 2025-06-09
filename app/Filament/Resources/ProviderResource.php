<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProviderResource\Pages;
use App\Filament\Resources\ProviderResource\RelationManagers;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProviderResource extends CustomerResource
{
    protected static ?string $model = Provider::class;

    protected static ?string $navigationGroup = 'Entities';

      public static function getNavigationLabel(): string
    {
        return __('Providers');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              
               Section::make('Provider Details')
               ->columns(2)
               ->schema(
                  self::getProviderFormSchema()
               ),
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
                    ->label("Provider Name")
                     ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label("Provider Email")
                     ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact')
                    ->label("Provider Contact")
                     ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label("Provider Address")
                    ->sortable()
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
            'index' => Pages\ListProviders::route('/'),
            'create' => Pages\CreateProvider::route('/create'),
            'edit' => Pages\EditProvider::route('/{record}/edit'),
        ];
    }
    public static function getProviderFormSchema(): array
    {
        return [
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
                Forms\Components\KeyValue::make('data')
                    ->label("Extra Details")
                    ->columnSpanFull(),
        ];
    }
}
