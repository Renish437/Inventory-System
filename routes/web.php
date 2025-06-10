<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/print-invoice/{id}', [App\Http\Controllers\InvoiceController::class, 'printInvoice'])->name('print-invoice');
