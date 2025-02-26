<?php

namespace App\Services;

use App\Models\Discount;
use Carbon\Carbon;

class DiscountService
{
    public function applyDiscount($cart)
    {
        $discount = Discount::where('code', $cart['code'])->where('is_active', true)->first();

        if (!$discount) {
            return ['message' => 'Invalid or inactive discount code.', 'total' => $cart['subtotal']];
        }

        if ($discount->active_from && Carbon::now()->lt(Carbon::parse($discount->active_from))) {
            return ['message' => 'Discount is not yet active.', 'total' => $cart['subtotal']];
        }

        if ($discount->active_to && Carbon::now()->gt(Carbon::parse($discount->active_to))) {
            return ['message' => 'Discount has expired.', 'total' => $cart['subtotal']];
        }

        if ($discount->min_cart_total && $cart['subtotal'] < $discount->min_cart_total) {
            return ['message' => 'Cart total does not meet minimum requirement.', 'total' => $cart['subtotal']];
        }

        $discountAmount = $discount->discount_type === 'percentage'
            ? ($cart['subtotal'] * ($discount->amount / 100))
            : $discount->amount;

        $newTotal = max(0, $cart['subtotal'] - $discountAmount);

        return ['message' => 'Discount applied.', 'total' => $newTotal, 'discount' => $discountAmount];
    }
}
