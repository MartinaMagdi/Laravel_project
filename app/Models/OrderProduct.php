<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = ['quantity'];

    function product()
    {
        return $this->belongsTo(Product::class);
    }

    function order() {
        return $this->belongsTo(Order::class);
    }
}
