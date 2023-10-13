<?php

namespace App\Models;

use App\Models\Category;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'image', 'price', 'category_id', 'available'];

    function category()
    {
        return $this->belongsTo(Category::class);
    }

    function order_products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
