<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyDiscountRequest;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Resources\DiscountResource;
use App\Services\DiscountService;
use App\Models\Discount;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class DiscountController extends Controller
{
    use ApiResponse;

    protected $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    // new discount
    public function store(StoreDiscountRequest $request)
    {
        $discount = Discount::create($request->validated());

        return $this->apiResponse('Discount was created successfully!', new DiscountResource($discount), true, 201);
    }

    // apply discount to the cart
    public function applyDiscount(ApplyDiscountRequest $request)
    {
        $cart = $request->validated();

        $result = $this->discountService->applyDiscount($cart);

        return $this->apiResponse(
            $result['message'],
            [
                'total' => $result['total'],
                'discount' => $result['discount'] ?? 0
            ],
            $result['message'] === 'Discount applied.',
            201
        );
    }
}
