<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\PurchaseResource;
use App\Models\Purchase;

use Filament\Facades\Filament;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPuchases extends BaseWidget
{
   

    public function table(Table $table): Table
    {
        return $table
            ->query(
               Purchase::latest()
            )
            ->columns([
                  TextColumn::make("invoice_no")
                  ->sortable()
                  ->searchable(),
                TextColumn::make("provider.name")
                ->searchable()
                ->sortable(),

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
            ->actions([
                Action::make('view_invoice')
                    ->url(function($record){
                        return PurchaseResource::getUrl("invoice",['tenant'=>Filament::getTenant()->id,'record'=>$record->id]);
                    })
                    
            ]);
    }
}
