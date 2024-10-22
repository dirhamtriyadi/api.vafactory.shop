<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashFlowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'transaction_date' => $this->transaction_date,
            'cash_flow_type' => $this->cash_flow_type,
            'amount' => $this->amount,
            'payment_methods_id' => $this->payment_methods_id,
            // 'payment_method' => $this->paymentMethod,
            'payment_method' => new PaymentMethodResource($this->whenLoaded('paymentMethod')),
            'description' => $this->description,
            'user' => $this->user
        ];
    }
}
