<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function printType()
    {
        return $this->belongsTo(PrintType::class, 'print_type_id', 'id');
    }

    public function orderTransaction()
    {
        return $this->hasMany(OrderTransaction::class, 'order_id', 'id');
    }

    public function orderTracking()
    {
        return $this->hasMany(OrderTracking::class, 'order_id', 'id');
    }
}
