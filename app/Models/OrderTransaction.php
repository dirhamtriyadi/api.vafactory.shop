<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_methods_id', 'id');
    }

    function createdBy() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
