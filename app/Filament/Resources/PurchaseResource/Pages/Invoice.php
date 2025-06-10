<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Models\Purchase;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;

class Invoice extends Page
{
    protected static string $resource = PurchaseResource::class;

    public $record;
    public $purchase;

    public function mount($record)
    {
        $this->record = $record;
        $this->purchase = Purchase::with('products','provider')->find($record);
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('Print')
                ->icon('heroicon-s-printer')
                ->requiresConfirmation()
                ->url(route('print-invoice',$this->record)),
        ];
    }
    protected static string $view = 'filament.resources.purchase-resource.pages.invoice';


}
