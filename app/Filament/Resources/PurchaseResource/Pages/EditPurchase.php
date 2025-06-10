<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditPurchase extends EditRecord
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
//    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
// {
//     // Extract and remove the nested 'products' data
//     $products = $data['products'] ?? [];
//     unset($data['products']);

//     // Fallbacks for amounts
//     $totalAmount = 0;

//     // Calculate totalAmount from product details
//     foreach ($products as $product) {
//         $price = floatval($product['price'] ?? 0);
//         $quantity = floatval($product['quantity'] ?? 0);
//         $totalAmount += $price * $quantity;
//     }

//     $discount = floatval($data['discount'] ?? 0);
//     $netTotal = $totalAmount - $discount;

//     // Manually set totals in case they were excluded due to disabled inputs
//     $data['total_amount'] = $totalAmount;
//     $data['discount'] = $discount;
    

//     // Update the purchase record
//     $record->update($data);

//     // Sync product items (delete old ones, insert new)
//     $record->products()->delete();

//     foreach ($products as $product) {
//         $record->products()->create([
//             'product_id' => $product['product_id'],
//             'price' => $product['price'],
//             'quantity' => $product['quantity'],
//         ]);
//     }

//     return $record;
// }

}
