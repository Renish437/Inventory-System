<?php

namespace App\Http\Controllers;

use App\Models\InvoiceRecord;
use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    //
    public function printInvoice($id)
    {
        $purchase = Purchase::with('products','provider')->find($id);
        if($purchase){
             InvoiceRecord::create([
           "purchase_id"=>$id,
           "user_id"=>Auth::user()->id

       ]);
      $pdf= Pdf::loadView('filament.pdf.purchase_invoice',compact('purchase'));
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
