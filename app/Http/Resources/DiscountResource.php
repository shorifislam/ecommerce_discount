<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'code' => $this->code,
            'discount_type' => $this->discount_type,
            'amount' => $this->amount,
            'min_cart_total' => $this->min_cart_total,
            'is_active' => $this->is_active,
            'active_from' => $this->active_from,
            'active_to' => $this->active_to,
        ];
    }
}
