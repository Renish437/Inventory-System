<?php

namespace App\Http\Controllers;

use App\Models\InvoiceRecord;
use App\Models\Purchase;
use App\Services\SettingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    //
    public function printInvoice($tenantId,$id)
    {
        $purchase = Purchase::with('products','provider')->find($id);
        if($purchase){
             InvoiceRecord::create([
           "purchase_id"=>$id,
           "user_id"=>Auth::user()->id

       ]);
    $settings = SettingService::getSettings(['Tenant Name', 'Address','Logo','Email','City','Zip'],$tenantId);
      $pdf= Pdf::loadView('filament.pdf.purchase_invoice',compact('purchase','settings'));
      return $pdf->stream();
        }else{
            Notification::make()
            ->title("No purchase record found")
            ->danger()
            ->send();
            return redirect()->back();
        }

    }
}
