<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qrcode', [QrCodeController::class, 'index']);
Route::get('/generate-qrcode', [QrCodeController::class, 'generateQrCode'])->name('generate.qrcode');
