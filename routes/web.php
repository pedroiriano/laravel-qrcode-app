<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StallTypeController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\RetributionController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [PagesController::class, 'index'])->name('home');

Route::get('/qrcode', [QrCodeController::class, 'index']);
Route::get('/generate-qrcode', [QrCodeController::class, 'generateQrCode'])->name('generate.qrcode');

Auth::routes();

Route::get('/backend', [BackendController::class, 'index'])->name('backend');

Route::get('/role', [RoleController::class, 'index'])->name('role');
Route::get('/role/create', [RoleController::class, 'create'])->name('role-form');
Route::post('/role', [RoleController::class, 'store'])->name('role-store');
Route::get('/role/{role}', [RoleController::class, 'show'])->name('role-show');
Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('role-edit');
Route::put('/role/{role}', [RoleController::class, 'update'])->name('role-update');
Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('role-delete');

Route::get('/user', [UserController::class, 'index'])->name('user');
Route::get('/user/create', [UserController::class, 'create'])->name('user-form');
Route::post('/user', [UserController::class, 'store'])->name('user-store');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user-show');
Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user-edit');
Route::put('/user/{user}', [UserController::class, 'update'])->name('user-update');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user-delete');

Route::get('/stall-type', [StallTypeController::class, 'index'])->name('stall-type');
Route::get('/stall-type/create', [StallTypeController::class, 'create'])->name('stall-type-form');
Route::post('/stall-type', [StallTypeController::class, 'store'])->name('stall-type-store');
Route::get('/stall-type/{stall_type}', [StallTypeController::class, 'show'])->name('stall-type-show');
Route::get('/stall-type/{stall_type}/edit', [StallTypeController::class, 'edit'])->name('stall-type-edit');
Route::put('/stall-type/{stall_type}', [StallTypeController::class, 'update'])->name('stall-type-update');
Route::delete('/stall-type/{stall_type}', [StallTypeController::class, 'destroy'])->name('stall-type-delete');

Route::get('/stall', [StallController::class, 'index'])->name('stall');
Route::get('/stall/create', [StallController::class, 'create'])->name('stall-form');
Route::post('/stall', [StallController::class, 'store'])->name('stall-store');
Route::get('/stall/{stall}', [StallController::class, 'show'])->name('stall-show');
Route::get('/stall/{stall}/edit', [StallController::class, 'edit'])->name('stall-edit');
Route::put('/stall/{stall}', [StallController::class, 'update'])->name('stall-update');
Route::delete('/stall/{stall}', [StallController::class, 'destroy'])->name('stall-delete');

Route::get('/merchant', [MerchantController::class, 'index'])->name('merchant');
Route::get('/merchant/create', [MerchantController::class, 'create'])->name('merchant-form');
Route::post('/merchant', [MerchantController::class, 'store'])->name('merchant-store');
Route::get('/merchant/{merchant}', [MerchantController::class, 'show'])->name('merchant-show');
Route::get('/merchant/{merchant}/edit', [MerchantController::class, 'edit'])->name('merchant-edit');
Route::put('/merchant/{merchant}', [MerchantController::class, 'update'])->name('merchant-update');
Route::delete('/merchant/{merchant}', [MerchantController::class, 'destroy'])->name('merchant-delete');

Route::get('/rent', [RentController::class, 'index'])->name('rent');
Route::get('/rent/create', [RentController::class, 'create'])->name('rent-form');
Route::post('/rent', [RentController::class, 'store'])->name('rent-store');
Route::get('/rent/{rent}', [RentController::class, 'show'])->name('rent-show');
Route::get('/rent/{rent}/edit', [RentController::class, 'edit'])->name('rent-edit');
Route::put('/rent/{rent}', [RentController::class, 'update'])->name('rent-update');
Route::delete('/rent/{rent}', [RentController::class, 'destroy'])->name('rent-delete');

Route::get('/retribution', [RetributionController::class, 'index'])->name('retribution');
Route::get('/retribution/create', [RetributionController::class, 'create'])->name('retribution-form');
Route::post('/retribution', [RetributionController::class, 'store'])->name('retribution-store');
Route::get('/retribution/{retribution}', [RetributionController::class, 'show'])->name('retribution-show');
Route::get('/retribution/{retribution}/edit', [RetributionController::class, 'edit'])->name('retribution-edit');
Route::put('/retribution/{retribution}', [RetributionController::class, 'update'])->name('retribution-update');
Route::delete('/retribution/{retribution}', [RetributionController::class, 'destroy'])->name('retribution-delete');
