<?php

namespace App\Models;

use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'status', 'note', 'creator_id'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function order_products() {
        return $this->hasMany(OrderProduct::class);
    }


}
