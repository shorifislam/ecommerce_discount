<?php

use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;

Route::post('/discounts', [DiscountController::class, 'store']);
Route::post('/apply-discount', [DiscountController::class, 'applyDiscount']);
