<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            // 'order_id' => $this->order_id,
            // 'order' => new OrderResource($this->whenLoaded('order')),
            'order' => new OrderResource($this->whenLoaded('order')),
            // 'payment_method_id' => $this->payment_method_id,
            // 'payment_method' => new PaymentMethodResource($this->whenLoaded('paymentMethod')),
            'payment_method' => new PaymentMethodResource($this->whenLoaded('paymentMethod')),
            // 'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'amount' => $this->amount,
            'date' => $this->date,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
