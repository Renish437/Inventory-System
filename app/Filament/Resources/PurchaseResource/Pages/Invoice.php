<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Services\SettingService;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Resources\Pages\Page;



class Invoice extends Page
{
    protected static string $resource = PurchaseResource::class;

    public $record;
    public $purchase;
    public $settings;

    public function mount($record)
    {
        $this->record = $record;
        $this->purchase = Purchase::with('products','provider')->find($record);
         $this->settings = SettingService::getSettings(['Tenant Name', 'Address','Logo','Email','City','Zip'],Filament::getTenant()->id);
       
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('Print')
                ->icon('heroicon-s-printer')
                ->requiresConfirmation()
                ->url(route('print-invoice',['tenant' => Filament::getTenant()->id,$this->record])),
        ];
    }
    protected static string $view = 'filament.resources.purchase-resource.pages.invoice';


}
