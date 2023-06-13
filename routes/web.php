<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qrcode', [QrCodeController::class, 'index']);
Route::get('/generate-qrcode', [QrCodeController::class, 'generateQrCode'])->name('generate.qrcode');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
